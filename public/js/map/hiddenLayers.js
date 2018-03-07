function showHiddenLayers() {
    let depth = map.getView().getZoom();
    for (let i = 0; i < hiddenLayers.length; i++) {
        let layer = hiddenLayers[i];
        if (depth <= layer['minDepth']) {
            removeHiddenLayer(layer)
        } else if (areaVisible(layer['area'])) {
            addHiddenLayer(layer);
        } else {
            removeHiddenLayer(layer)
        }
    }
}

function removeHiddenLayers() {
    for (let i = 0; i < hiddenLayers.length; i++) {
        removeHiddenLayer(hiddenLayers[i]);
    }
}

function areaVisible(area) {
    let visibleArea = map.getView().calculateExtent(map.getSize());
    if (area[0] < visibleArea[0] && area[2] < visibleArea[0]) {
        return false; // Left of view
    } else if (area[1] < visibleArea[1] && area[3] < visibleArea[1]) {
        return false; // Below view
    } else if (area[2] > visibleArea[2] && area[0] > visibleArea[2]) {
        return false; // Right of view
    } else if (area[3] > visibleArea[3] && area[1] > visibleArea[3]) {
        return false; // Above view
    }
    return true; // In view
}

// Skullsmasherz
function addHiddenLayer(layer) {
    if (layer['items'].length === 0) {
        $.ajax({
            url: 'tiles/hidden-layers/' + layer['name'] + '/items.json',
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    let dataItem = data[i];
                    dataItem['id'] = i;
                    dataItem['type'] = 'hiddenLayer';
                    dataItem['url'] = 'tiles/hidden-layers/' + layer['name'] + '/' + i + '/{z}/{x}/{y}.png';
                    let url = '';
                    if (dataItem['visible']) {
                        url = dataItem['url'];
                    } else {
                        url = 'map-viewing-tools/hidden.png';
                    }
                    let layer = new ol.layer.Tile({
                        source: new ol.source.XYZ({
                            projection: 'PIXELS',
                            tileGrid: new ol.tilegrid.TileGrid({
                                extent: dataItem['extent'],
                                minZoom: dataItem['minDepth'],
                                tileSize: dataItem['size'],
                                resolutions: mapResolutions
                            }),
                            url: url,
                            wrapX: false
                        }),
                        data: dataItem
                    });
                    layer['items'].push(layer);
                    if (areaVisible(dataItem['extent'])) {
                        map.addLayer(layer);
                    }
                }
            }
        });
    } else {
        for (let i = 0; i < layer['items'].length; i++) {
            if (areaVisible(layer['items'][i].get('data')['extent'])) {
                map.addLayer(layer['items'][i]);
            }
        }
    }
}
function removeHiddenLayer(layer) {
    for (let i = 0; i < layer['items'].length; i++) {
        map.removeLayer(layer['items'][i]);
    }
}

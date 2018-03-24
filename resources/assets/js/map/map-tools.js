window.OlMap = require('ol/map').default;
window.OlLayerTile = require('ol/layer/tile').default;
window.OlControl = require('ol/control').default;
window.OlControlFullscreen = require('ol/control/fullscreen').default;
window.OlTilegrid = require('ol/tilegrid/tilegrid').default;
window.OlSourceXYZ = require('ol/source/xyz').default;
window.OlView = require('ol/view').default;
window.mapTileGrid = new OlTilegrid({
    extent: [extendModifier * -1, extendModifier * -1, extendModifier, extendModifier],
    minZoom: mapMinZoom,
    resolutions: mapResolutions
});

window.showScale = function (sender) {
    sender.classList.toggle('selected');
    let scaleContainer = document.getElementById('scale-container');
    scaleContainer.style.display = scaleContainer.style.display === "none" ? "block" : "none";
    sender.blur();
};

window.showGrid = function (sender) {
    sender.classList.toggle('selected');
    if (sender.classList.contains('selected')) {
        map.addLayer(gridLayer);
    } else {
        map.removeLayer(gridLayer);
    }
    sender.blur();
};

window.updateScale = function () {
    let zoom = map.getView().getZoom();
    let modifier = Math.pow(2, zoom - 20);
    for (let i = 0; i < movableObjects.length; i++) {
        let overlay = movableObjects[i]['overlay'];
        let data = movableObjects[i]['data'];
        let element = document.getElementById(data['id']);
        if (element) {
            if (element.dataset.minDepth < (zoom + 1) && element.dataset.maxDepth >= zoom) {
                let width = (data['size'][0] * modifier);
                let height = (data['size'][1] * modifier);
                let url = '';
                if (element.dataset.killed === 'true') {
                    url = data['killedsrc'];
                } else {
                    url = data['src'];
                }
                overlay.setPosition([element.dataset.positionX, element.dataset.positionY]);
                let style = 'display: block;' +
                    'width: ' + width + 'px;' +
                    'height: ' + height + 'px;' +
                    'overflow: hidden;' +
                    'line-height: ' + height + 'px;' +
                    'background-image: url(' + url + ');' +
                    'background-repeat: no-repeat;' +
                    'background-size: 100%;';
                element.setAttribute('style', style);
            } else {
                overlay.setPosition(undefined);
            }
        }
    }
    let depth = map.getView().getResolution();
    let scaleWidth = (50 / (256 / (depth / 256)));
    if (depth <= 256) {
        scaleWidth = Math.round(scaleWidth * 5280);
        document.getElementById('scale').innerHTML = scaleWidth + ' Foot';
    } else if (depth <= 1024) {
        scaleWidth = Math.round(scaleWidth * 1760);
        document.getElementById('scale').innerHTML = scaleWidth + ' Yards';
    } else {
        scaleWidth = Math.round(scaleWidth);
        document.getElementById('scale').innerHTML = scaleWidth + ' Miles';
    }
};

// Layers
let layers = [];
layers.push(
    new OlLayerTile({
        source: new OlSourceXYZ({
            projection: 'PIXELS',
            tileGrid: mapTileGrid,
            url: "/map/" + mapId + "/getTile/{z}/{x}/{y}",
            wrapX: false
        })
    })
);
gridLayer = new OlLayerTile({
    source: new OlSourceXYZ({
        projection: 'PIXELS',
        tileGrid: mapTileGrid,
        url: "/images/map-viewing-tools/image.php?z={z}&x={x}&y={y}",
        wrapX: false
    })
});

// Map

window.map = new OlMap({
    controls: OlControl.defaults().extend([
        new OlControlFullscreen({
            source: 'fullScreen'
        })
    ]),
    target: 'map',
    layers: layers,
    view: new OlView({
        maxResolution: mapTileGrid.getResolution(mapMinZoom),
        center: [centerX, centerY],
        zoom: centerZ,
        resolutions: mapResolutions
    })
});

updateScale();

map.getView().on('propertychange', function (e) {
    switch (e.key) {
        case 'resolution':
            updateScale();
            break;
    }
});

if (sessionActive) {
    map.on('movestart', function (e) {
        removeHiddenLayers();
    });

    map.on('moveend', function (e) {
        showHiddenLayers();
    });
}

map.on('click', function (evt) {
    if (sessionActive) {
        map.forEachLayerAtPixel(evt.pixel, function (layer) {
            let data = layer.get('data');
            if (data && !data['visible']) {
                data['visible'] = true;
                layer.setSource(OlSourceXYZ({
                    projection: 'PIXELS',
                    tileGrid: new OlTilegrid({
                        extent: data['extent'],
                        minZoom: data['minDepth'],
                        tileSize: data['size'],
                        resolutions: mapResolutions
                    }),
                    url: data['url'],
                    wrapX: false
                }));
            }
        });
    }

    let coordinates = evt.coordinate;
    let depth = map.getView().getZoom();
    let lat = Math.round(coordinates[1]);
    let lon = Math.round(coordinates[0]);
    let coordinatesElement = document.getElementById('coordinates');
    if (develop) {
        coordinatesElement.innerHTML = "X: " + lon + " Y: " + lat + " Z: " + depth;
        let lonOld = coordinatesElement.dataset.x;
        let latOld = coordinatesElement.dataset.y;
        if (lonOld && latOld) {
            coordinatesElement.innerHTML = coordinatesElement.innerHTML + "<br/>X&Delta;: " + (lonOld - lon) + " Y&Delta;: " + (latOld - lat);
        }
        coordinatesElement.dataset.x = lon;
        coordinatesElement.dataset.y = lat;
    }

    // Copy Link
    let copyElement = document.createElement('input');
    copyElement.setAttribute('id', 'linkInput');
    copyElement.value = "http://" + serverName + "?x=" + lon + "&y=" + lat + "&z=" + depth;
    coordinatesElement.appendChild(copyElement);
    copyElement.select();
    document.execCommand("Copy");
    copyElement.parentElement.removeChild(copyElement);
});

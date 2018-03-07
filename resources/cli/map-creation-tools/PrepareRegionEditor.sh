#!/bin/bash

function PrepareRegionEditor() {
    xOriginal=$1
    yOriginal=$2
    sourceImage="tiles/9/${xOriginal}/${yOriginal}.jpg";

    _createBaseLayer

    (( xLeft = ${xOriginal} * 32 ))
    (( xLeftCheck = ${xLeft} - 1))
    (( yTop = ${yOriginal} * 32 ))
    (( yTopCheck = ${yTop} - 1))
    (( xRight = ${xOriginal} * 32 + 31 ))
    (( xRightCheck = ${xRight} + 1))
    (( yBottom = ${yOriginal} * 32 + 31 ))
    (( yBottomCheck = ${yBottom} + 1))

    if [[ -f "tiles/14/${xRight}/${yTopCheck}.jpg" ]]; then
        echo "Adding top edge..."
        _prepareHorizontalEdge ${yTopCheck} ${xLeft} ${xRight} North
    fi
    if [[ -f "tiles/14/${xRightCheck}/${yBottom}.jpg" ]]; then
        echo "Adding right edge..."
        _prepareVerticalEdge ${xRightCheck} ${yTop} ${yBottom} SouthEast
    fi
    if [[ -f "tiles/14/${xLeft}/${yBottomCheck}.jpg" ]]; then
        echo "Adding bottom edge..."
        _prepareHorizontalEdge ${yBottomCheck} ${xLeft} ${xRight} SouthWest
    fi
    if [[ -f "tiles/14/${xLeftCheck}/${yTop}.jpg" ]]; then
        echo "Adding left edge..."
        _prepareVerticalEdge ${xLeftCheck} ${yTop} ${yBottom} NorthWest
    fi

	gimp -i -b '(create-region-start-image "start.jpg" "edges.png" "start.xcf")' -b '(gimp-quit 0)'

    rm "edges.png"
    rm "start.jpg"
    mv "start.xcf" "9_${xOriginal}_${yOriginal}.xcf"

    gimp "9_${xOriginal}_${yOriginal}.xcf"
}

function _createBaseLayer() {
    echo "Creating base layer"
    convert +repage "${sourceImage}" -resize 8192x8192 "start.jpg"
    convert +repage "start.jpg" -gravity Center -extent 8704x8704 "start.jpg"
    convert -size 8704x8704 xc:none "edges.png"
}

function _prepareHorizontalEdge() {
    appendImages="map-creation-tools/blank.jpg" # Corner
    for x in $(eval echo "{$2..$3}"); do
        appendImages="${appendImages} tiles/14/${x}/$1.jpg"
    done
    appendImages="${appendImages} map-creation-tools/blank.jpg"
    convert ${appendImages} +append "edge.jpg"
    convert "edges.png" "edge.jpg" -gravity $4 -composite "edges.png"
    rm "edge.jpg"
}

function _prepareVerticalEdge() {
    appendImages="map-creation-tools/blank.jpg" # Corner
    for y in $(eval echo "{$2..$3}"); do
        appendImages="${appendImages} tiles/14/$1/${y}.jpg"
    done
    appendImages="${appendImages} map-creation-tools/blank.jpg"
    convert ${appendImages} -append "edge.jpg"
    convert "edges.png" "edge.jpg" -gravity $4 -composite "edges.png"
    rm "edge.jpg"
}

if [[ $1 == "--help" ]]; then
	echo "Tiler_PrepareRegionEditor will create all tiles from z0 to max resolution z for the given image (starting on the given zxy location)."
	return
fi

if [[ $# -gt 0 ]]; then
    xOriginal=$1
fi

if [[ $# -gt 1 ]]; then
    yOriginal=$2
fi

if [[ -z ${xOriginal} ]]; then
    read -p "Original x: " xOriginal
fi
if [[ -z ${yOriginal} ]]; then
    read -p "Original y: " yOriginal
fi

PrepareRegionEditor ${xOriginal} ${yOriginal}

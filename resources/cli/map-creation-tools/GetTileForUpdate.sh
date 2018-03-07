#!/bin/bash

zOriginalPath=$1
zOriginal=$2
xOriginal=$3
yOriginal=$4
depth=$5
zMaxDepthPath=$6
sourceImage="${zOriginalPath}/${xOriginal}/${yOriginal}.jpg";

_createBaseLayer ${depth}

(( zMax = ${zOriginal} + ${depth} ))
(( xLeft = ${xOriginal} * 32 ))
(( xLeftCheck = ${xLeft} - 1))
(( yTop = ${yOriginal} * 32 ))
(( yTopCheck = ${yTop} - 1))
(( xRight = ${xOriginal} * 32 + 31 ))
(( xRightCheck = ${xRight} + 1))
(( yBottom = ${yOriginal} * 32 + 31 ))
(( yBottomCheck = ${yBottom} + 1))

if [[ -f "${zMaxDepthPath}/${xRight}/${yTopCheck}.jpg" ]]; then
    _prepareHorizontalEdge ${zMaxDepthPath} ${yTopCheck} ${xLeft} ${xRight} North
fi
if [[ -f "${zMaxDepthPath}/${xRightCheck}/${yBottom}.jpg" ]]; then
    _prepareVerticalEdge ${zMaxDepthPath} ${xRightCheck} ${yTop} ${yBottom} SouthEast
fi
if [[ -f "${zMaxDepthPath}/${xLeft}/${yBottomCheck}.jpg" ]]; then
    _prepareHorizontalEdge ${zMaxDepthPath} ${yBottomCheck} ${xLeft} ${xRight} SouthWest
fi
if [[ -f "${zMaxDepthPath}/${xLeftCheck}/${yTop}.jpg" ]]; then
    _prepareVerticalEdge ${zMaxDepthPath} ${xLeftCheck} ${yTop} ${yBottom} NorthWest
fi

gimp -i -b '(create-region-start-image "start.jpg" "edges.png" "start.xcf")' -b '(gimp-quit 0)'

rm "edges.png"
rm "start.jpg"
mv "start.xcf" "${zMax}_${xOriginal}_${yOriginal}.xcf"

function _createBaseLayer() {
    depth=$1
    (( size = 256 * 2 ** ${depth} ))
    (( sizeWithEdge = ${size} + 512 ))
    convert +repage "${sourceImage}" -resize ${size}x${size} "start.jpg"
    convert +repage "start.jpg" -gravity Center -extent ${sizeWithEdge}x${sizeWithEdge} "start.jpg"
    convert -size ${sizeWithEdge}x${sizeWithEdge} xc:none "edges.png"
}

function _prepareHorizontalEdge() {
    appendImages="map-creation-tools/blank.jpg" # Corner
    for x in $(eval echo "{$3..$4}"); do
        appendImages="${appendImages} $1/${x}/$2.jpg"
    done
    appendImages="${appendImages} resources/cli/map-creation-tools/blank.jpg"
    echo ${appendImages}
    convert ${appendImages} +append "edge.jpg"
    convert "edges.png" "edge.jpg" -gravity $5 -composite "edges.png"
    rm "edge.jpg"
}

function _prepareVerticalEdge() {
    appendImages="map-creation-tools/blank.jpg" # Corner
    for y in $(eval echo "{$3..$4}"); do
        appendImages="${appendImages} $1/$2/${y}.jpg"
    done
    appendImages="${appendImages} resources/cli/map-creation-tools/blank.jpg"
    convert ${appendImages} -append "edge.jpg"
    convert "edges.png" "edge.jpg" -gravity $5 -composite "edges.png"
    rm "edge.jpg"
}
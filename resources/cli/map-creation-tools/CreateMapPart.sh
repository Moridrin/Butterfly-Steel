#!/bin/bash

dir=$1
zMax=$2
zOriginal=0
xOriginal=0
yOriginal=0
ParentXArray=("${xOriginal}")
ParentYArray=("${yOriginal}")
overallCount=0;

(( overallCountMax = ${zMax} + 1 ))
(( properSize = 256 * (2 ** (${zMax} - ${zOriginal})) ))
actualSize=$(identify -format '%w' "${dir}/0/0/0.jpg")
echo ${actualSize}
echo ${properSize}
if [[ ${actualSize} -ne ${properSize} ]]; then
    convert "${dir}/0/0/0.jpg" -gravity center -crop ${properSize}x${properSize}+0+0 "${dir}/0/0/0.jpg"
fi
echo "${overallCountMax}" > "${dir}/overallCountMax"
echo "${overallCount}" > "${dir}/overallCurrent"

for z in $(eval echo "{$((${zOriginal} + 1))..${zMax}}"); do
    NewXArray=()
    NewYArray=()
    depthCount=0;
    (( depthCountMax = 4 ** ${z} ))
    echo "${depthCountMax}" > "${dir}/depthCountMax"
    echo ${depthCount} > "${dir}/depthCurrent"
    for arrayIndex in ${!ParentXArray[@]}; do
        xStart=${ParentXArray[${arrayIndex}]}
        yStart=${ParentYArray[${arrayIndex}]}
        file="${dir}/$((${z} - 1))/${xStart}/${yStart}.jpg"
        convert "${file}" -crop 50%x50% "${dir}/quarter-%d.jpg"
        for y in $(eval echo "{0..1}"); do
            yNew=$(echo $(expr ${yStart} \* 2))
            yNew=$(echo $(expr ${y} + ${yNew}))
            for x in $(eval echo "{0..1}"); do
                xNew=$(echo $(expr ${xStart} \* 2))
                xNew=$(echo $(expr ${x} + ${xNew}))
                mkdir -p "${dir}/${z}/${xNew}"
                CurrentFileID=$(echo $(expr 2 \* ${y}))
                CurrentFileID=$(echo $(expr ${CurrentFileID} + ${x}))
                mv "${dir}/quarter-${CurrentFileID}.jpg" "${dir}/${z}/${xNew}/${yNew}.jpg"
                ((depthCount++))
                echo ${depthCount} > "${dir}/depthCurrent"
                NewXArray+=("${xNew}")
                NewYArray+=("${yNew}")
            done
        done
        convert "${file}" -resize 256x256 "${file}"
    done
    ((overallCount++))
    echo "${overallCount}" > "${dir}/overallCurrent"
    ParentXArray=(${NewXArray[@]})
    ParentYArray=(${NewYArray[@]})
done
((overallCount++))
echo "${overallCount}" > "${dir}/overallCurrent"

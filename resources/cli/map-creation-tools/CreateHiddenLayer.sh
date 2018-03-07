#!/bin/bash

function CreateHiddenLayer() {
    inputImage=$1

	# Determine max z
	width=$(identify -format '%w' ${inputImage})
	height=$(identify -format '%h' ${inputImage})

	# Keep Size
	mkdir -p "20/0/"
	cp ${inputImage} "20/0/0.png"

	for z in `seq 3`; do
		ParentZDir="$PWD/$((2${z} - 1))/*"
		for dir in ${ParentZDir}; do
			if [[ -d ${dir} ]]; then

				xStart="${dir##*/}"

				for file in ${dir}/*; do

					yStart=$(basename "${file}")
					yStart="${yStart%.*}"
					echo "z: 2$((${z} - 1)) x: ${xStart} y: ${yStart}"
					convert "${file}" +repage -crop 50%x50% quarter-%d.png

					for y in {0..1}; do

						yNew=$(echo $(expr ${yStart} \* 2))
						yNew=$(echo $(expr ${y} + ${yNew}))

						for x in {0..1}; do

							xNew=$(echo $(expr ${xStart} \* 2))
							xNew=$(echo $(expr ${x} + ${xNew}))
							mkdir -p "2${z}/${xNew}"

							CurrentFileID=$(echo $(expr 2 \* ${y}))
							CurrentFileID=$(echo $(expr ${CurrentFileID} + ${x}))

							mv "quarter-${CurrentFileID}.png" "2${z}/${xNew}/${yNew}.png"
							echo "2${z}/${xNew}/${yNew}.png"
						done
					done
				done
			fi
		done
	done
	echo $(expr ${width} \/ 4)
	echo $(expr ${height} \/ 4)
}


if [[ $1 == "--help" ]]; then
    echo "Tiler_CreateTiles will create all tiles from z0 to max resolution z of image."
    return
fi

if [[ $# -gt 0 ]]; then
    inputImage=$1
fi
while ! [[ -f ${inputImage} ]]; do
    read -p "Input Image: " inputImage
done

CreateHiddenLayer ${inputImage}

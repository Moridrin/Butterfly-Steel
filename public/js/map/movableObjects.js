let touchMove = false;
let currentMonstersVersion = 0;
let currentPlayersVersion = 0;

function updateVersions() {
    $.ajax({
        url: 'json/versions.json?timestamp=' + Date.now(),
        async: false,
        dataType: 'json',
        success: function (data) {
            if (currentMonstersVersion < data['monsters']) {
                currentMonstersVersion = data['monsters'];
                initMonsters();
            }
            if (currentPlayersVersion < data['players']) {
                currentPlayersVersion = data['players'];
                initPlayers();
            }
        }
    });
}

updateVersions();

if (sessionActive) {
    setInterval(function () {
        updateVersions();
    }, 1000);
}

// Monsters
function initMonsters() {
    $.ajax({
        url: 'monsters/monsters.json?version=' + Date.now(),
        dataType: 'json',
        success: function (data) {
            initMovableObject(
                function (itemData, i) {
                    itemData['id'] = itemData['monsterType'] + '_' + i;
                    itemData['type'] = 'monsters';
                    itemData['url'] = 'https://www.dndbeyond.com/monsters/' + itemData['monsterType'];
                    itemData['killedsrc'] = '/monsters/' + itemData['monsterType'] + '-dead.png';
                    itemData['src'] = '/monsters/' + itemData['monsterType'] + '.png';
                    itemData['playerMovable'] = true;
                },
                data,
                function (itemData, element, overlay) {
                    if (develop) {
                        var menu = [
                            {
                                name: 'Kill',
                                fun: function () {
                                    killMonster(element);
                                }
                            },
                            {
                                name: 'Conditions',
                                subMenu: [
                                    {
                                        name: 'Blinded',
                                        title: 'A blinded creature can\'t see and automatically fails any ability check that requires sight.\n' +
                                        'Attack rolls against the creature have advantage, and the creature\'s attack rolls have disadvantage.',
                                        fun: function () {
                                            alert('You are now blinded');
                                        }
                                    },
                                    {
                                        name: 'Charmed',
                                        title: 'A charmed creature can\'t attack the charmer or target the charmer with harmful abilities or magical effects.\n' +
                                        'The charmer has advantage on any ability check to interact socially with the creature.',
                                        fun: function () {
                                            alert('You are now charmed');
                                        }
                                    },
                                    {
                                        name: 'Deafened',
                                        title: 'A deafened creature can\'t hear and automatically fails any ability check that requires hearing',
                                        fun: function () {
                                            alert('You are now deafend');
                                        }
                                    },
                                    {
                                        name: 'Exhaustion',
                                        title: 'A deafened creature can\'t hear and automatically fails any ability check that requires hearing',
                                        subMenu: [
                                            {
                                                name: 'Disadvantage on ability checks',
                                                title: 'Disadvantage on ability checks',
                                                fun: function () {
                                                    alert('You are now 1 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Speed halved',
                                                title: 'Speed halved',
                                                fun: function () {
                                                    alert('You are now 2 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Disadvantage on attack rolls and saving throws',
                                                title: 'Disadvantage on attack rolls and saving throws',
                                                fun: function () {
                                                    alert('You are now 3 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Hit point maximum halved',
                                                title: 'Hit point maximum halved',
                                                fun: function () {
                                                    alert('You are now 4 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Speed reduced to 0',
                                                title: 'Speed reduced to 0',
                                                fun: function () {
                                                    alert('You are now 5 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Death',
                                                title: 'Death',
                                                fun: function () {
                                                    alert('You are now dead');
                                                }
                                            }
                                        ]
                                    },
                                    {
                                        name: 'Frightened',
                                        title: 'A frightened creature has disadvantage on ability checks and attack rolls while the source of its fear is within line of sight.\n' +
                                        'The creature can\'t willingly move closer to the source of its fear.',
                                        fun: function () {
                                            alert('You are now Frightened');
                                        }
                                    },
                                    {
                                        name: 'Grappled',
                                        title: 'A grappled creature\'s speed becomes 0, and it can\'t benefit from any bonus to its speed.\n' +
                                        'The condition ends if the grappler is incapacitated (see the condition).\n' +
                                        'The condition also ends if an effect removes the grappled creature from the reach of the grappler or grappling effect, such as when a creature is hurled away by the thunderwave spell.',
                                        fun: function () {
                                            alert('You are now Grappled');
                                        }
                                    },
                                    {
                                        name: 'Incapacitated',
                                        title: 'An incapacitated creature can\'t take actions or reactions.',
                                        fun: function () {
                                            alert('You are now Incapacitated');
                                        }
                                    },
                                    {
                                        name: 'Invisible',
                                        title: 'An invisible creature is impossible to see without the aid of magic or a special sense. For the purpose of hiding, the creature is heavily obscured. The creature\'s location can be detected by any noise it makes or any tracks it leaves.\n' +
                                        'Attack rolls against the creature have disadvantage, and the creature\'s attack rolls have advantage.',
                                        fun: function () {
                                            alert('You are now Invisible');
                                        }
                                    },
                                    {
                                        name: 'Paralyzed',
                                        title: 'A paralyzed creature is incapacitated (see the condition) and can\'t move or speak.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws. Attack rolls against the creature have advantage.\n' +
                                        'Any attack that hits the creature is a critical hit if the attacker is within 5 feet of the creature.',
                                        fun: function () {
                                            alert('You are now Paralyzed');
                                        }
                                    },
                                    {
                                        name: 'Petrified',
                                        title: 'A petrified creature is transformed, along with any nonmagical object it is wearing or carrying, into a solid inanimate substance (usually stone). Its weight increases by a factor of ten, and it ceases aging.\n' +
                                        'The creature is incapacitated (see the condition), can\'t move or speak, and is unaware of its surroundings.\n' +
                                        'Attack rolls against the creature have advantage.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'The creature has resistance to all damage.\n' +
                                        'The creature is immune to poison and disease, although a poison or disease already in its system is suspended, not neutralized.',
                                        fun: function () {
                                            alert('You are now Petrified');
                                        }
                                    },
                                    {
                                        name: 'Poisoned',
                                        title: 'A poisoned creature has disadvantage on attack rolls and ability checks.',
                                        fun: function () {
                                            alert('You are now Poisoned');
                                        }
                                    },
                                    {
                                        name: 'Prone',
                                        title: 'A prone creature\'s only movement option is to crawl, unless it stands up and thereby ends the condition.\n' +
                                        'The creature has disadvantage on attack rolls.\n' +
                                        'An attack roll against the creature has advantage if the attacker is within 5 feet of the creature. Otherwise, the attack roll has disadvantage.',
                                        fun: function () {
                                            alert('You are now Prone');
                                        }
                                    },
                                    {
                                        name: 'Restrained',
                                        title: 'A restrained creature\'s speed becomes 0, and it can\'t benefit from any bonus to its speed.\n' +
                                        'Attack rolls against the creature have advantage, and the creature\'s attack rolls have disadvantage.\n' +
                                        'The creature has disadvantage on Dexterity saving throws.',
                                        fun: function () {
                                            alert('You are now Restrained');
                                        }
                                    },
                                    {
                                        name: 'Stunned',
                                        title: 'A stunned creature is incapacitated (see the condition), can\'t move, and can speak only falteringly.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'Attack rolls against the creature have advantage.',
                                        fun: function () {
                                            alert('You are now Stunned');
                                        }
                                    },
                                    {
                                        name: 'Unconscious',
                                        title: 'An unconscious creature is incapacitated, can\'t move or speak, and is unaware of its surroundings\n' +
                                        'The creature drops whatever it\'s holding and falls prone.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'Attack rolls against the creature have advantage.\n' +
                                        'Any attack that hits the creature is a critical hit if the attacker is within 5 feet of the creature.',
                                        fun: function () {
                                            alert('You are now Unconscious');
                                        }
                                    },
                                ]
                            },
                            {
                                name: 'D&D Beyond Page',
                                title: 'Open the monster in ',
                                fun: function () {
                                    window.open(itemData['url']);
                                }
                            }
                        ];

                        //Calling context menu
                        $(element).contextMenu(menu);
                    }
                }
            );
            for (let i = 0; i < data.length; i++) {
                document.getElementById(data[i]['id']).setAttribute('oncontextmenu', 'killMonster(' + data[i]['id'] + '); return false;');
            }
        }
    });
}

// Players
function initPlayers() {
    $.ajax({
        url: 'players/players.json?version=' + Date.now(),
        dataType: 'json',
        success: function (data) {
            initMovableObject(
                function (itemData, i) {
                    itemData['size'] = [16, 16];
                    itemData['id'] = itemData['playerName'] + '_' + i;
                    itemData['type'] = 'players';
                    itemData['playerMovable'] = true;
                    itemData['src'] = '/players/' + itemData['playerName'] + '.png';
                },
                data,
                function (data, element, overlay) {
                    if (develop) {
                        var menu = [
                            {
                                name: 'Conditions',
                                subMenu: [
                                    {
                                        name: 'Blinded',
                                        title: 'A blinded creature can\'t see and automatically fails any ability check that requires sight.\n' +
                                        'Attack rolls against the creature have advantage, and the creature\'s attack rolls have disadvantage.',
                                        fun: function () {
                                            alert('You are now blinded');
                                        }
                                    },
                                    {
                                        name: 'Charmed',
                                        title: 'A charmed creature can\'t attack the charmer or target the charmer with harmful abilities or magical effects.\n' +
                                        'The charmer has advantage on any ability check to interact socially with the creature.',
                                        fun: function () {
                                            alert('You are now charmed');
                                        }
                                    },
                                    {
                                        name: 'Deafened',
                                        title: 'A deafened creature can\'t hear and automatically fails any ability check that requires hearing',
                                        fun: function () {
                                            alert('You are now deafend');
                                        }
                                    },
                                    {
                                        name: 'Exhaustion',
                                        title: 'A deafened creature can\'t hear and automatically fails any ability check that requires hearing',
                                        subMenu: [
                                            {
                                                name: 'Disadvantage on ability checks',
                                                title: 'Disadvantage on ability checks',
                                                fun: function () {
                                                    alert('You are now 1 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Speed halved',
                                                title: 'Speed halved',
                                                fun: function () {
                                                    alert('You are now 2 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Disadvantage on attack rolls and saving throws',
                                                title: 'Disadvantage on attack rolls and saving throws',
                                                fun: function () {
                                                    alert('You are now 3 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Hit point maximum halved',
                                                title: 'Hit point maximum halved',
                                                fun: function () {
                                                    alert('You are now 4 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Speed reduced to 0',
                                                title: 'Speed reduced to 0',
                                                fun: function () {
                                                    alert('You are now 5 level exhausted');
                                                }
                                            },
                                            {
                                                name: 'Death',
                                                title: 'Death',
                                                fun: function () {
                                                    alert('You are now dead');
                                                }
                                            }
                                        ]
                                    },
                                    {
                                        name: 'Frightened',
                                        title: 'A frightened creature has disadvantage on ability checks and attack rolls while the source of its fear is within line of sight.\n' +
                                        'The creature can\'t willingly move closer to the source of its fear.',
                                        fun: function () {
                                            alert('You are now Frightened');
                                        }
                                    },
                                    {
                                        name: 'Grappled',
                                        title: 'A grappled creature\'s speed becomes 0, and it can\'t benefit from any bonus to its speed.\n' +
                                        'The condition ends if the grappler is incapacitated (see the condition).\n' +
                                        'The condition also ends if an effect removes the grappled creature from the reach of the grappler or grappling effect, such as when a creature is hurled away by the thunderwave spell.',
                                        fun: function () {
                                            alert('You are now Grappled');
                                        }
                                    },
                                    {
                                        name: 'Incapacitated',
                                        title: 'An incapacitated creature can\'t take actions or reactions.',
                                        fun: function () {
                                            alert('You are now Incapacitated');
                                        }
                                    },
                                    {
                                        name: 'Invisible',
                                        title: 'An invisible creature is impossible to see without the aid of magic or a special sense. For the purpose of hiding, the creature is heavily obscured. The creature\'s location can be detected by any noise it makes or any tracks it leaves.\n' +
                                        'Attack rolls against the creature have disadvantage, and the creature\'s attack rolls have advantage.',
                                        fun: function () {
                                            alert('You are now Invisible');
                                        }
                                    },
                                    {
                                        name: 'Paralyzed',
                                        title: 'A paralyzed creature is incapacitated (see the condition) and can\'t move or speak.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws. Attack rolls against the creature have advantage.\n' +
                                        'Any attack that hits the creature is a critical hit if the attacker is within 5 feet of the creature.',
                                        fun: function () {
                                            alert('You are now Paralyzed');
                                        }
                                    },
                                    {
                                        name: 'Petrified',
                                        title: 'A petrified creature is transformed, along with any nonmagical object it is wearing or carrying, into a solid inanimate substance (usually stone). Its weight increases by a factor of ten, and it ceases aging.\n' +
                                        'The creature is incapacitated (see the condition), can\'t move or speak, and is unaware of its surroundings.\n' +
                                        'Attack rolls against the creature have advantage.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'The creature has resistance to all damage.\n' +
                                        'The creature is immune to poison and disease, although a poison or disease already in its system is suspended, not neutralized.',
                                        fun: function () {
                                            alert('You are now Petrified');
                                        }
                                    },
                                    {
                                        name: 'Poisoned',
                                        title: 'A poisoned creature has disadvantage on attack rolls and ability checks.',
                                        fun: function () {
                                            alert('You are now Poisoned');
                                        }
                                    },
                                    {
                                        name: 'Prone',
                                        title: 'A prone creature\'s only movement option is to crawl, unless it stands up and thereby ends the condition.\n' +
                                        'The creature has disadvantage on attack rolls.\n' +
                                        'An attack roll against the creature has advantage if the attacker is within 5 feet of the creature. Otherwise, the attack roll has disadvantage.',
                                        fun: function () {
                                            alert('You are now Prone');
                                        }
                                    },
                                    {
                                        name: 'Restrained',
                                        title: 'A restrained creature\'s speed becomes 0, and it can\'t benefit from any bonus to its speed.\n' +
                                        'Attack rolls against the creature have advantage, and the creature\'s attack rolls have disadvantage.\n' +
                                        'The creature has disadvantage on Dexterity saving throws.',
                                        fun: function () {
                                            alert('You are now Restrained');
                                        }
                                    },
                                    {
                                        name: 'Stunned',
                                        title: 'A stunned creature is incapacitated (see the condition), can\'t move, and can speak only falteringly.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'Attack rolls against the creature have advantage.',
                                        fun: function () {
                                            alert('You are now Stunned');
                                        }
                                    },
                                    {
                                        name: 'Unconscious',
                                        title: 'An unconscious creature is incapacitated, can\'t move or speak, and is unaware of its surroundings\n' +
                                        'The creature drops whatever it\'s holding and falls prone.\n' +
                                        'The creature automatically fails Strength and Dexterity saving throws.\n' +
                                        'Attack rolls against the creature have advantage.\n' +
                                        'Any attack that hits the creature is a critical hit if the attacker is within 5 feet of the creature.',
                                        fun: function () {
                                            alert('You are now Unconscious');
                                        }
                                    },
                                ]
                            },
                            {
                                name: 'Player Page',
                                title: 'Open the player page on Moridrin.com',
                                fun: function () {
                                    window.open(data['url']);
                                }
                            }
                        ];

                        //Calling context menu
                        $(element).contextMenu(menu);
                    }
                }
            );
        }
    });
}

// noinspection JSUnusedGlobalSymbols
function killMonster(element) {
    let backgroundImage = $(element).css('background-image');
    element.dataset.killed = true;
    $(element).css('background-image', backgroundImage.replace('.png', '-dead.png'));
    $.ajax({
        url: 'monsters/killed.php',
        data: {id: element.id}
    });
}

function initMovableObject(preInit, data, postInit) {
    for (let i = 0; i < data.length; i++) {
        preInit(data[i], i);
        data[i]['minDepth'] = 20;
        data[i]['maxDepth'] = 23;
        let element = document.createElement('a');
        element.setAttribute('id', data[i]['id']);
        element.setAttribute('class', data[i]['type']);
        element.setAttribute('draggable', 'true');
        element.dataset.minDepth = data[i]['minDepth'];
        element.dataset.maxDepth = data[i]['maxDepth'];
        element.dataset.killed = data[i]['killed'];
        element.dataset.positionX = data[i]['position'][0];
        element.dataset.positionY = data[i]['position'][1];
        element.setAttribute('href', data[i]['url']);
        element.setAttribute('target', '_blank');
        document.getElementById('movableObjects').appendChild(element);
        let overlay = new ol.Overlay({
            id: data[i]['id'],
            position: data[i]['position'],
            element: element
        });
        let tmp = map.getOverlayById(data[i]['id']);
        if (tmp) {
            map.removeOverlay(tmp);
        }
        map.addOverlay(overlay);
        movableObjects.push({overlay: overlay, data: data[i]});

        if (data[i]['playerMovable']) {
            element.addEventListener('touchmove', function (event) {
                let resolution = map.getView().getResolution();
                let mapCenter = map.getView().getCenter();
                let viewCenter = [$(window).width() / 2, $(window).height() / 2];
                let touch = event.targetTouches[0];
                let positionX = mapCenter[0] + (((touch.pageX - viewCenter[0]) - ($(this).width() / 2)) * resolution);
                let positionY = mapCenter[1] - (((touch.pageY - viewCenter[1]) - ($(this).height() / 2)) * resolution);
                overlay.setPosition([positionX, positionY]);
                event.preventDefault();
                touchMove = true;
            }, false);

            element.addEventListener('touchend', function (event) {
                if (touchMove) {
                    $.ajax({
                        url: data[i]['type'] + '/moved.php',
                        data: {id: element.id, lon: overlay.getPosition()[0], lat: overlay.getPosition()[1]}
                    });
                    touchMove = false;
                }
            }, false);
        }

        let img = new Image();
        element.addEventListener("dragstart", function (e) {
            e.dataTransfer.setDragImage(img, 0, 0);
        }, false);

        element.addEventListener('drag', function (event) {
            let resolution = map.getView().getResolution();
            let mapCenter = map.getView().getCenter();
            let viewCenter = [$(window).width() / 2, $(window).height() / 2];
            if (event.x === 0 && event.y === 0) {
                return;
            }
            let positionX = mapCenter[0] + (((event.x - viewCenter[0]) - ($(this).width() / 2)) * resolution);
            let positionY = mapCenter[1] - (((event.y - viewCenter[1]) - ($(this).height() / 2)) * resolution);
            overlay.setPosition([positionX, positionY]);
            event.preventDefault();
        }, false);

        if (data[i]['type'] === 'monsters') {
            element.setAttribute('oncontextmenu', 'killMonster(' + data[i]['id'] + '); return false;');
        }

        element.addEventListener('dragend', function (event) {
            $.ajax({
                url: data[i]['type'] + '/moved.php',
                data: {id: element.id, lon: overlay.getPosition()[0], lat: overlay.getPosition()[1]}
            });
            this.dataset.positionX = overlay.getPosition()[0];
            this.dataset.positionY = overlay.getPosition()[1];
        }, false);

        postInit(data[i], element, overlay);
    }
    updateScale();
}

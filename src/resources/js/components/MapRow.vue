<template>
    <tr :key="row" :id="'row-' + row">
        <td class="row-header">{{ row }}</td>
        <td v-for="col in 9" :key="col">
            <div :id="row + '-' + col" class="section" v-on:drop="drop(event)" v-on:dragover="allowDrop(event)"></div>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            row: {
                type: String
            }
        },
        data() {
            return {
                shipBox: null
            }
        },
        mounted() {
            this.shipBox = document.getElementById("ship-box");
        },
        methods: {
            // drag and drop engedéjezése
            allowDrop(ev){
                ev.preventDefault();
            },
            // hajó elengedése
            drop(ev) {
                ev.preventDefault();
                var id = ev.dataTransfer.getData("id");     // hajó id-ja
                var size = parseInt(id.split("-").pop());   // hajó mérete
                var className = ev.dataTransfer.getData("className");   // hajó classje
                var isRotated = className.split(" ").includes("rotate-ship");   // vizszintes vagy fuggoleges
                var tmp = ev.target.id.split("-");  // koordináták
                var row = parseInt(tmp[0]);     // sorszám
                var col = parseInt(tmp[1]);     // oszlopszám
                if(map[row][col] == 1) return;  // ha már van hajó a koordinátán, akkor kilépünk
                if(isRotated){
                    // függőleges hajó esetén
                    var step = 1;   // lépés
                    var spaceUp = 0, spaceDown = 0; // szabad helyek száma felfele és lefele
                    // szabad helyek számolása felfele
                    while(true){
                        if(row - step < 0) break;
                        if(map[row-step][col] == 0){
                            ++spaceUp;
                            ++step;
                        }
                        else break;
                    }
                    step = 1;
                    // szabad helyek számolása lefele
                    while(true){
                        if(row + step > 9) break;
                        if(map[row+step][col] == 0){
                            ++spaceDown;
                            ++step;
                        }
                        else break;
                    }
                    // ha nincs elég hely a hajónak, kilépünk
                    var allSpaces = spaceUp + spaceDown + 1;
                    if(allSpaces < size){
                        return;
                    }

                    var stepUp = Math.floor(size / 2);  // hajóelemek száma felfele
                    var stepDown = size - stepUp - 1;   // hajóelemek száma lefele

                    // hajó elosztása a szabad helyeken
                    if(stepUp > spaceUp){
                        stepUp = spaceUp;
                        stepDown = size - stepUp - 1;
                    }
                    else if(stepDown > spaceDown){
                        stepDown = spaceDown;
                        stepUp = size - stepDown - 1;
                    }

                    // hajó felső részének elhelyezése
                    for(var i = stepUp ; i > 0 ; --i){
                        var newDiv = document.createElement("div"); // új hajóelem elkészítése
                        if(i == stepUp){    // ha a hajóelem a hajó felső vége
                            newDiv.className = "ship-end-up";
                            map[row-i][col] = 1;
                        }
                        else{   // ha hajótörzs
                            newDiv.className = "ship-body-vertical";
                            map[row-i][col] = 3;
                        }
                        // hajóelem beszúrása a html-be
                        document.getElementById("" + (row-i) + "-" + col).appendChild(newDiv);
                    }

                    // hajó alsó részének elhelyezése
                    for(var i = stepDown ; i > 0 ; --i){
                        var newDiv = document.createElement("div"); // új hajóelem elkészítése
                        if(i == stepDown){      // ha a hajóelem a hajó alsó vége
                            newDiv.className = "ship-end-down";
                            map[row+i][col] = 2;
                        }
                        else{   // ha hajótörzs
                            newDiv.className = "ship-body-vertical";
                            map[row+i][col] = 3;
                        }
                        // hajóelem beszúrása a html-be
                        document.getElementById("" + (row + i) + "-" + col).appendChild(newDiv);
                    }

                    // a koordinátán levő hajóelem
                    var newDiv = document.createElement("div"); // új hajóelem létrehozása
                    if(stepDown == 0){      // ha a hajóelem a hajó alsó vége
                        newDiv.className = "ship-end-down";
                        map[row][col] = 2;
                    }
                    else if(stepUp == 0){   // ha a hajóelem a hajó felső vége
                        newDiv.className = "ship-end-up";
                        map[row][col] = 1;
                    }
                    else{       // ha a hajóelem hajótörzs
                        newDiv.className = "ship-body-vertical";
                        map[row][col] = 3;
                    }
                    // hajóelem beszúrása a html-be
                    ev.target.appendChild(newDiv);
                }
                else{
                    // Vízszintes hajó esetén
                    var step = 1;   // lépés
                    var spaceLeft = 0, spaceRight = 0;  // szabad helyek száma balra és jobbra
                    // szabad helyek számolása balra
                    while(true){
                        if(col - step < 0) break;
                        if(map[row][col-step] == 0){
                            ++spaceLeft;
                            ++step;
                        }
                        else break;
                    }
                    step = 1;
                    // szabad helyek számolása jobbra
                    while(true){
                        if(col + step > 9) break;
                        if(map[row][col+step] == 0){
                            ++spaceRight;
                            ++step;
                        }
                        else break;
                    }
                    // ha nincs elég hely a hajónak, kilépünk
                    var allSpaces = spaceLeft + spaceRight + 1;
                    if(allSpaces < size){
                        return;
                    }

                    var stepRight = Math.floor(size / 2);   // hajóelemek száma jobbra
                    var stepLeft = size - stepRight - 1;    // hajóelemek száma balra

                    // hajó elosztása a szabad helyeken
                    if(stepLeft > spaceLeft){
                        stepLeft = spaceLeft;
                        stepRight = size - stepLeft - 1;
                    }
                    else if(stepRight > spaceRight){
                        stepRight = spaceRight;
                        stepLeft = size - stepRight - 1;
                    }
                    
                    // hajó bal oldali részének elhelyezése
                    for(var i = stepLeft ; i > 0 ; --i){
                        var newDiv = document.createElement("div"); // új hajóelem készítése
                        if(i == stepLeft){  // ha a hajóelem a hajó bal oldali vége
                            newDiv.className = "ship-end-left";
                            map[row][col-i] = -1;
                        }
                        else{   // ha a hajóelem hajótörzs
                            newDiv.className = "ship-body-horizontal";
                            map[row][col-i] = -3;
                        }
                        // hajóelem beszúrása a html-be
                        document.getElementById("" + row + "-" + (col - i)).appendChild(newDiv);
                    }

                    // hajó jobb oldali részének elhelyezése
                    for(var i = stepRight ; i > 0 ; --i){
                        var newDiv = document.createElement("div"); // új hajóelem készítése
                        if(i == stepRight){     // ha a hajóelem a hajó jobb oldali vége
                            newDiv.className = "ship-end-right";
                            map[row][col+i] = -2;
                        }
                        else{   // ha a hajóelem hajótörzs     
                            newDiv.className = "ship-body-horizontal";
                            map[row][col+i] = -3;
                        }
                        // hajóelem beszúrása a html-be
                        document.getElementById("" + row + "-" + (col + i)).appendChild(newDiv);
                    }

                    // a koordinátán levő hajóelem
                    var newDiv = document.createElement("div"); // új hajóelem létrehozása
                    if(stepRight == 0){    // ha a hajóelem a hajó jobb oldali vége
                        newDiv.className = "ship-end-right";
                        map[row][col] = -2;
                    }  
                    else if(stepLeft == 0){     // ha a hajóelem a hajó bal oldali vége
                        newDiv.className = "ship-end-left";
                        map[row][col] = -1;
                    }
                    else{   // ha a hajóelem hajótörzs   
                        newDiv.className = "ship-body-horizontal";
                        map[row][col] = -3;
                    }
                    // hajóelem beszúrása a html-be
                    ev.target.appendChild(newDiv);
                }

                // hajó törlése a hajókat tartalmazó dobozból
                shipBox.removeChild(document.getElementById(id));

                // amikor elfogynak a hajók, a játék indító gomb aktívvá válik
                if(shipBox.children.length == 0){
                    document.getElementById("start-game-btn").classList.toggle("disabled-btn");
                }
            }
        }
    }
</script>

<style>
    .row-header {
        padding-right: 10px;
        font-weight: bold;
    }

    .section {
        position: relative;
        width: 38px;
        height: 38px;
        background-color: lightblue;
    }
</style>
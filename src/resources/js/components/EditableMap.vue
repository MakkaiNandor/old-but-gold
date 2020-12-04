<template>
    <table>
        <tr>
            <th v-for="letter in letters" :key="letter">{{ letter }}</th>
        </tr>
        <tr v-for="row in numbers" :key="row" :id="'row-' + row">
            <td style="padding-right: 10px; font-weight: bold;">{{ row }}</td>
            <td v-for="col in numbers" :key="col">
                <div :id="row + '-' + col" class="section" v-on:drop="drop($event)" v-on:dragover="allowDrop($event)"></div>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                letters: ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
                numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                map: [
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                ]
            }
        },
        computed: {
            // hajókat tartalmazó doboz
            shipBox: function() {
                return document.getElementById("ship-box");
            },
            // játék indító gomb
            startGameBtn: function() {
                return document.getElementById("start-game-btn");
            }
        },
        methods: {
            /**
             * Játék indítása, játéktér továbbküldése
             */
            startGame(event) {
                event.preventDefault();
                var data = JSON.stringify(this.map);
                var form = document.getElementById("start-game-form");
                form.data.value = data;
                form.submit();
            },
            /**
             * Drop engedéjezése
             */
            allowDrop(event) {
                event.preventDefault();
            },
            /**
             * Hajó felhelyezése a játéktérre
             */
            drop(event) {
                event.preventDefault();
                if(event.target.className != "section") return;
                
                var shipId = event.dataTransfer.getData("id");
                var shipSize = parseInt(shipId.split("-").pop());   // hajó mérete
                var isRotated = event.dataTransfer.getData("className").split(" ").includes("rotate-ship");   // vízszintes vagy függőleges
                // koordináták
                var targetId = event.target.id.split("-");
                var row = parseInt(targetId[0]);
                var col = parseInt(targetId[1]);

                if(this.map[row][col] != 0) return;  // ha már van hajó a koordinátán, akkor kilépünk

                if(isRotated){  // függőleges hajó
                    var spacesUp = this.countSpaces(row, col, -1, 0);  // szabad helyek felfele
                    var spacesDown = this.countSpaces(row, col, 1, 0);  // szabad helyek lefele
                    var allSpaces = spacesUp + spacesDown + 1;  // összes szabad hely
                    if(allSpaces < shipSize) return;  // ha nincs elég hely, akkor kilépünk
                    var shipPositioning = this.getShipPositioning(shipSize, spacesUp, spacesDown);  // hajó elhelyezkedése
                    this.placingShipPart(shipPositioning[0], row, col, -1, 0);  // hajó felső részének elhelyezése
                    // hajó közepének elhelyezése
                    var newDiv = document.createElement("div");
                    newDiv.className = shipPositioning[0] == 0 ? "ship-end-up" : (shipPositioning[1] == 0 ? "ship-end-down" :  "ship-body-vertical");
                    this.map[row][col] = shipPositioning[0] == 0 ?  1 : (shipPositioning[1] == 0 ?  2 :  3);
                    event.target.appendChild(newDiv);
                    this.placingShipPart(shipPositioning[1], row, col, 1, 0);  // hajó alsó részének elhelyezése
                }
                else{  // vízszintes hajó
                    var spacesLeft = this.countSpaces(row, col, 0, -1);  // szabad helyek balra
                    var spacesRight = this.countSpaces(row, col, 0, 1);  // szabad helyek jobbra
                    var allSpaces = spacesLeft + spacesRight + 1;  // összes szabad hely
                    if(allSpaces < shipSize) return;  // ha nincs elég hely, akkor kilépünk
                    var shipPositioning = this.getShipPositioning(shipSize, spacesLeft, spacesRight);  // hajó elhelyezkedése
                    this.placingShipPart(shipPositioning[0], row, col, 0, -1);  // hajó bal oldali részének elhelyezése
                    // hajó közepének elhelyezése
                    var newDiv = document.createElement("div");
                    newDiv.className = shipPositioning[0] == 0 ?  "ship-end-left" : (shipPositioning[1] == 0 ?  "ship-end-right" :  "ship-body-horizontal");
                    this.map[row][col] = shipPositioning[0] == 0 ?  -1 : (shipPositioning[1] == 0 ?  -2 :  -3);
                    event.target.appendChild(newDiv);
                    this.placingShipPart(shipPositioning[1], row, col, 0, 1);  // hajó jobb oldali részének elhelyezése
                }
                this.shipBox.removeChild(document.getElementById(shipId));
                // amikor elfogynak a hajók, a játék indító gomb aktívvá válik
                if(this.shipBox.children.length == 0){
                    this.startGameBtn.addEventListener("click", this.startGame);
                    this.startGameBtn.classList.toggle("disabled-btn");
                }
            },
            // szabad helyek számolása egy adott irányba
            /**
             * Szabad helyek számolása egy adott irányba
             * 
             * @param {number} row
             * @param {number} col
             * @param {number} stepRow
             * @param {number} stepCol
             * @return {number}
             */
            countSpaces(row, col, stepRow, stepCol) {
                var spaces = 0;
                while(true){
                    // számoljuk a szabad helyeket az adott irányba, amíg találunk egy foglalt helyet vagy elérünk a játéktér végére 
                    if(stepRow > 0 && row + spaces + stepRow > 9) break;
                    else if(stepRow < 0 && row - spaces + stepRow < 0) break;
                    else if(stepCol > 0 && col + spaces + stepCol > 9) break;
                    else if(stepCol < 0 && col - spaces + stepCol < 0) break;
                    if(this.map[row+(spaces+1)*stepRow][col+(spaces+1)*stepCol] == 0){
                        ++spaces;
                    }
                    else break;
                }
                return spaces;
            },
            /**
             * Kiszámolja a hajó eloszlását a szabad helyek alapján
             * 
             * @param {number} shipSize Hajó mérete
             * @param {number} spaces1 Szabad helyek száma fel vagy balra 
             * @param {number} spaces2 Szabad helyek száma le vagy jobbra
             * @return {Array<number>} Eloszlás
             */
            getShipPositioning(shipSize, spaces1, spaces2) {
                // optimális eloszlás
                var shipPositioning1 = Math.floor(shipSize / 2);
                var shipPositioning2 = shipSize - shipPositioning1 - 1;

                // lehetséges eloszlás
                if(shipPositioning1 > spaces1){
                    shipPositioning1 = spaces1;
                    shipPositioning2 = shipSize - shipPositioning1 - 1;
                }
                else if(shipPositioning2 > spaces2){
                    shipPositioning2 = spaces2;
                    shipPositioning1 = shipSize - shipPositioning2 - 1;
                }

                return [shipPositioning1, shipPositioning2]
            },
            /**
             * Hajó egyik részének (felső, alsó, bal vagy jobb oldali) elhelyezése a játéktéren
             * 
             * @param {number} size Elhelyezendő rész mérete
             * @param {number} row
             * @param {number} col
             * @param {number} stepRow
             * @param {number} stepCol
             */
            placingShipPart(size, row, col, stepRow, stepCol) {
                var className1 = "", className2 = "", code1 = 0, code2 = 0;
                // paraméterek beállítása az irány szerint
                if(stepRow == -1) {
                    className1 = "ship-end-up"; code1 = 1;
                    className2 = "ship-body-vertical"; code2 = 3;
                }
                else if(stepRow == 1) {
                    className1 = "ship-end-down"; code1 = 2;
                    className2 = "ship-body-vertical"; code2 = 3;
                }
                else if(stepCol == -1) {
                    className1 = "ship-end-left"; code1 = -1;
                    className2 = "ship-body-horizontal"; code2 = -3;
                }
                else if(stepCol == 1) {
                    className1 = "ship-end-right"; code1 = -2;
                    className2 = "ship-body-horizontal"; code2 = -3;
                }
                // darabok elhelyezése
                for(var i = size ; i > 0 ; --i){
                    var newDiv = document.createElement("div");
                    if(i == size){
                        // hajó vége
                        newDiv.className = className1;
                        this.map[row+stepRow*i][col+stepCol*i] = code1;
                    }
                    else{
                        // hajó törzse
                        newDiv.className = className2;
                        this.map[row+stepRow*i][col+stepCol*i] = code2;
                    }
                    document.getElementById("" + (row+stepRow*i) + "-" + (col+stepCol*i)).appendChild(newDiv);
                }
            }
        }
    }
</script>

<style>
    .section {
        position: relative;
        width: 38px;
        height: 38px;
        background-color: lightblue;
    }

    .ship-body-horizontal {
        position: absolute;
        background-color: brown;
        top: 2px;
        left: -1px;
        right: -1px;
        bottom: 2px;
    }

    .ship-body-vertical {
        position: absolute;
        background-color: brown;
        top: -1px;
        left: 2px;
        right: 2px;
        bottom: -1px;
    }

    .ship-end-up {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: 2px;
        right: 2px;
        bottom: -1px;
        border-radius: 50px 50px 0 0;
    }

    .ship-end-down {
        position: absolute;
        background-color:brown;
        top: -1px;
        left: 2px;
        right: 2px;
        bottom: 2px;
        border-radius: 0 0 50px 50px;
    }

    .ship-end-left {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: 2px;
        right: -1px;
        bottom: 2px;
        border-radius: 50px 0 0 50px;
    }

    .ship-end-right {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: -1px;
        right: 2px;
        bottom: 2px;
        border-radius: 0 50px 50px 0;
    }
</style>
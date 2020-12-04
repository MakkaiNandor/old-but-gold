// konstans változók
/** A hajók méretei */
const SHIPS = [5, 4, 3, 3 ,2];
const GAME_TYPE = {
    SINGLEPLAYER: 0,
    MULTIPLAYER: 1
};
const USER_TYPE = {
    GUEST: 0,
    REGISTERED: 1
}
const ORIENTATION = {
    VERTICAL: 0,
    HORIZONTAL: 1
};
/** Irányok: fel, le, balra és jobbra */
const DIRECTIONS = [
    [-1, 0],
    [1, 0],
    [0, -1],
    [0, 1]
];
/** Oszlopok kódjai */
const LETTERS = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"];

/** Felhasználó objektum */
class Me {
    /** 
     * @param {Array<Array<number>>} map A felhasználó játéktere
     * @param {USER_TYPE} userData  Felhasználó típusa
     */
    constructor(map, userData) {
        this.type = userData ? USER_TYPE.REGISTERED : USER_TYPE.GUEST;
        this.id = userData ? userData.userId : -1;
        this.level = userData ? userData.userLvl : -1;
        this.xp = userData ? userData.userXp : -1;
        this.map = map;
        this.ships = 17;
        this.numberOfShots = 0;
        this.numberOfHits = 0;
    }
}

/** Ellenfél objektum, egyszemélyes játékmód esetén */
class ComputerEnemy {
    constructor() {
        this.map = [                        // számítógép játéktere (üres)
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
        ];
        this.shots = [                      // ide menti a számítógép a lövéseit
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
        ];
        this.ships = 17;
        this.numberOfShots = 0;
        this.numberOfHits = 0;
        this.prevHit = [false, -1, -1];
        this.generateShips();
    }

    /**
     * Kigenerálja a következő célpont koordinátáit
     * 
     * @return {Array<number>} Tartalmazza a sor- és oszlopszámot
     */
    getNextTarget(){
        var row, col;
        if(this.prevHit[0]){
            // ha az előző lövés találat volt, keresünk egy célpontot a szomszédságban
            for(var dir of DIRECTIONS){
                var stepRow = dir[0];
                var stepCol = dir[1];
                if(this.prevHit[1] + stepRow < 0 || this.prevHit[1] + stepRow > 9 || this.prevHit[2] + stepCol < 0 || this.prevHit[2] + stepCol > 9) 
                    continue;
                else if(this.shots[this.prevHit[1]+stepRow][this.prevHit[2]+stepCol] != 0)
                    continue;
                else{
                    row = this.prevHit[1] + stepRow;
                    col = this.prevHit[2] + stepCol;
                    break;
                }
            }
        }
        // az előző lövés nem találat volt vagy nem talál célpontot a szomszédságban
        if(!row && !col){
            // új koordináták generálása
            this.prevHit[0] = false;
            do{
                row = Math.floor(Math.random() * 10);
                col = Math.floor(Math.random() * 10);
            }while(this.shots[row][col] != 0);
        }
        return [row, col];
    }

    /**
     * Elvétett lövés
     * 
     * @param {number} row
     * @param {number} col
     */
    miss(row, col){
        this.shots[row][col] = 8;
    }

    /**
     * Találat
     * 
     * @param {number} row
     * @param {number} col
     */
    hit(row, col){
        this.shots[row][col] = 9;
    }

    /** Hajók véletlenszerű kigenerálása és felhelyezése a játéktérre */
    generateShips(){
        for(var shipSize of SHIPS){
            var orientation = Math.floor(Math.random() * 10) % 2 == 0 ? ORIENTATION.VERTICAL : ORIENTATION.HORIZONTAL;  // orientáció véletlenszerű kiválasztása
            var row, col;  // koordináták
            var allSpaces, spaces1, spaces2;  // szabad helyek
            while(true){  // koordináták generálása
                row = Math.floor(Math.random() * 10);
                col = Math.floor(Math.random() * 10);
                if(this.map[row][col] != 0) continue;
                // szabad hely keresése a hajó számára
                [allSpaces, spaces1, spaces2] = this.countSpaces(row, col, orientation);
                if(allSpaces >= shipSize) break;
            }
            // optimális elhelyezés
            var shipElements1 = Math.floor(shipSize / 2);
            var shipElements2 = shipSize - shipElements1 - 1;

            // lehetséges elhelyezés
            if(shipElements1 > spaces1){
                shipElements1 = spaces1;
                shipElements2 = shipSize - shipElements1 - 1;
            }
            else if(shipElements2 > spaces2){
                shipElements2 = spaces2;
                shipElements1 = shipSize - shipElements2 - 1;
            }

            // a hajó elhelyezése a játéktéren az orientációtól függően
            if(orientation == ORIENTATION.VERTICAL){
                for(var i = row - shipElements1; i <= row + shipElements2; ++i){
                    this.map[i][col] = 1;
                }
            }
            else{
                for(var i = col - shipElements1; i <= col + shipElements2; ++i){
                    this.map[row][i] = 1;
                }
            }
        }
    }

    /**
     * Szabad helyek számolása függőlegesen vagy vízszintesen
     * 
     * @param {number} row Egész szám. Intervallum: [0, 9]
     * @param {number} col Egész szám. Intervallum: [0, 9]
     * @param {ORIENTATION} orientation 
     * @return {Array<number>} Formátum: [összes szabad hely, szabad hely az egyik oldalon, szabad hely a másik oldalon]
     */
    countSpaces(row, col, orientation){
        var steps = orientation == ORIENTATION.VERTICAL ? [[-1, 0], [1, 0]] : [[0, -1], [0, 1]];
        var spaces = [0, 0];
        // ellenőrizzük az orientáció mindkét oldalát (fel-le vagy balra-jobbra)
        for(var step of steps){
            while(true){
                // számoljuk a szabad helyeket, amíg találunk egy foglalt helyet vagy a játéktér végét
                if(step[0] < 0 && row + step[0] < 0) break;
                else if(step[0] > 0 && row + step[0] > 9) break;
                else if(step[1] < 0 && col + step[1] < 0) break;
                else if(step[1] > 0 && col + step[1] > 9) break;
                if(this.map[row+step[0]][col+step[1]] == 0){
                    if(step[0] + step[1] < 0){
                        ++spaces[0];
                        if(step[0] < 0) --step[0];
                        else --step[1];
                    }
                    else{
                        ++spaces[1];
                        if(step[0] > 0) ++step[0];
                        else ++step[1];
                    }
                }
                else break;
            }
        }
        return [spaces[0] + spaces[1] + 1, spaces[0], spaces[1]];
    }
}

/** Az egyszemélyes játékmód objektuma. Tartalmazza a felhasználót és a számítógépet */
class SingleplayerGameplay {
    /**
     * @param {Array<Array<number>>} map Felhasználó játéktere
     * @param {object} userData Felhasználó adatai: id, szint, xp
     */
    constructor(map, userData) {
        this.me = new Me(map, userData);
        this.enemy = new ComputerEnemy();
        this.interval = null;
        this.startTime = new Date();
        this.endTime = null;
    }

    /**
     * Felhasználó lövése
     * 
     * @param {number} row 
     * @param {number} col 
     * @param {HTMLElement} target 
     */
    myShot(row, col, target){
        ++this.me.numberOfShots;
        document.getElementById("enemy-map").classList.add("blocked");  // blokkoljuk az ellenfél játékterét, miután a felhasználó lőtt
        target.classList.remove("shootable");  // a célpont lőhetetlenné válik
        var message, style;
        if(this.enemy.map[row][col] == 0){  // a lövés nem talált
            target.classList.add("miss");  // a célpont eltűnik
            // beállítunk pár információt a felhasználó számára
            document.getElementById("turn").innerHTML = "Enemy's turn!";
            message = "<strong>You</strong> shot " + row + LETTERS[col] + ", miss!";
            style = "style='color: red;'";
            this.interval = setInterval(this.enemyShot.bind(this), 1500);  // a számítógép fog következni periódikusan
        }
        else{  // a lövés talált
            target.classList.add("hit");  // animáció lejátszása
            // beállítunk pár információt a felhasználó számára
            message = "<strong>You</strong> shot " + row + LETTERS[col] + ", hit!";
            style = "style='color: green;'";
            ++this.me.numberOfHits;
            --this.enemy.ships;
            setTimeout(() => {
                document.getElementById("enemy-map").classList.remove("blocked");  // ellenfél játékterének feloldása
            })
        }
        // információk megjelenítése
        var messageBlock = document.getElementById("message-block");
        messageBlock.innerHTML += "<p " + style + ">" + message + "</p>";
        messageBlock.scrollTop = messageBlock.scrollHeight;
        if(this.enemy.ships == 0) this.gameOver();
    }

    /**
     * Számítógép lövése
     */
    enemyShot(){
        ++this.enemy.numberOfShots;
        var [row, col] = this.enemy.getNextTarget();  // a következő célpont koordinátái
        var target = document.getElementById("my-"+row+"-"+col);
        var message, style;
        if(this.me.map[row][col] == 0){  // a lövés nem talált
            target.classList.add("miss");  // a célpont eltűnik
            // beállítunk pár információt a felhasználó számára
            document.getElementById("turn").innerHTML = "Your turn!";
            message = "<strong>Computer</strong> shot " + row + LETTERS[col] + ", miss!";
            style = "style='color: red;'";
            this.enemy.miss(row, col);
            clearInterval(this.interval);  // leállítjuk a számítógép periódusát
            document.getElementById("enemy-map").classList.remove("blocked");  // ellenfél játékterének felszabadítása
        }
        else{  // a lövés talált
            this.enemy.prevHit = [true, row, col];
            target.removeChild(target.firstChild);
            target.classList.add("hit");  // animáció lejátszása
            // beállítunk pár információt a felhasználó számára
            message = "<strong>Computer</strong> shot " + row + LETTERS[col] + ", hit!";
            style = "style='color: green;'";
            ++this.enemy.numberOfHits;
            --this.me.ships;
            this.enemy.hit(row, col);
        }
        // információk megjelenítése
        var messageBlock = document.getElementById("message-block");
        messageBlock.innerHTML += "<p " + style + ">" + message + "</p>";
        messageBlock.scrollTop = messageBlock.scrollHeight;
        if(this.me.ships == 0){
            clearInterval(this.interval);
            this.gameOver();
        }
    }

    /** Játék vége */
    gameOver(){
        this.endTime = new Date();

        var youAreTheWinner = this.enemy.ships == 0;
        var title;
        if(youAreTheWinner){
            title = "You Won!";
        }
        else{
            title = "Computer Won!";
        }
        var gameOverBlock = document.getElementById("game-over-block");
        gameOverBlock.querySelector("#title").innerHTML = title;
        gameOverBlock.classList.remove("d-none");
        
        if(this.me.type == USER_TYPE.REGISTERED){
            // ha a felhasználó be van regisztrálva beállítjuk az adatokat és elküldjük őket a szerveroldalra
            var playedTime = Math.floor((this.endTime - this.startTime) / 1000);
            var reward = Math.floor((this.me.numberOfHits / this.me.numberOfShots) * (34 / playedTime) * 1000) + (youAreTheWinner ? 100 : 0);
            var userXpWidth = Math.floor(this.me.xp / 10);
            var rewardWidth = Math.floor(reward / 10);
            document.getElementById("reward").innerHTML = "+" + reward + " XP";
            document.getElementById("old-xp").style.width = userXpWidth + "%";
            document.getElementById("new-xp").style.width = rewardWidth + "%";
            var newGameForm = document.getElementById("new-game-form");
            newGameForm.player_one_id.value = this.me.id;
            newGameForm.player_two_id.value = 0;
            newGameForm.starting_time.value = this.startTime.toDateString();
            newGameForm.played_time.value = playedTime;
            newGameForm.player_one_xp.value = reward;
            newGameForm.player_two_xp.value = 0;
            newGameForm.winner.value = youAreTheWinner ? this.me.id : 0;
            newGameForm.submit();
        }
    }
}
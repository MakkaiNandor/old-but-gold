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
const DIRECTIONS = [
    [-1, 0],
    [1, 0],
    [0, -1],
    [0, 1]
];
const LETTERS = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"];

class Me {
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

class ComputerEnemy {
    constructor() {
        this.map = [
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
        this.shots = [
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

    getNextTarget(){
        var row, col;
        if(this.prevHit[0]){
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
        if(!row && !col){
            this.prevHit[0] = false;
            do{
                row = Math.floor(Math.random() * 10);
                col = Math.floor(Math.random() * 10);
            }while(this.shots[row][col] != 0);
        }
        return [row, col];
    }

    miss(row, col){
        this.shots[row][col] = 8;
    }

    hit(row, col){
        this.shots[row][col] = 9;
    }

    generateShips(){
        for(var shipSize of SHIPS){
            var orientation = Math.floor(Math.random() * 10) % 2 == 0 ? ORIENTATION.VERTICAL : ORIENTATION.HORIZONTAL;
            var row, col;
            var allSpaces, spaces1, spaces2;
            while(true){
                row = Math.floor(Math.random() * 10);
                col = Math.floor(Math.random() * 10);
                if(this.map[row][col] != 0) continue;
                [allSpaces, spaces1, spaces2] = this.countSpaces(row, col, orientation);
                if(allSpaces >= shipSize) break;
            }
            var shipElements1 = Math.floor(shipSize / 2);
            var shipElements2 = shipSize - shipElements1 - 1;

            if(shipElements1 > spaces1){
                shipElements1 = spaces1;
                shipElements2 = shipSize - shipElements1 - 1;
            }
            else if(shipElements2 > spaces2){
                shipElements2 = spaces2;
                shipElements1 = shipSize - shipElements2 - 1;
            }

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

    countSpaces(row, col, orientation){
        var steps = orientation == ORIENTATION.VERTICAL ? [[-1, 0], [1, 0]] : [[0, -1], [0, 1]];
        var spaces = [0, 0];
        for(var step of steps){
            while(true){
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

class SingleplayerGameplay {
    constructor(map, userData) {
        this.me = new Me(map, userData);
        this.enemy = new ComputerEnemy();
        this.interval = null;
        this.startTime = new Date();
        this.endTime = null;
    }

    myShot(row, col, target){
        ++this.me.numberOfShots;
        document.getElementById("enemy-map").classList.add("blocked");
        target.classList.remove("shootable");
        var message, style;
        if(this.enemy.map[row][col] == 0){
            target.classList.add("miss");
            document.getElementById("turn").innerHTML = "Enemy's turn!";
            message = "<strong>You</strong> shot " + row + LETTERS[col] + ", miss!";
            style = "style='color: red;'";
            this.interval = setInterval(this.enemyShot.bind(this), 1500);
        }
        else{
            target.classList.add("hit");
            message = "<strong>You</strong> shot " + row + LETTERS[col] + ", hit!";
            style = "style='color: green;'";
            ++this.me.numberOfHits;
            --this.enemy.ships;
            setTimeout(() => {
                document.getElementById("enemy-map").classList.remove("blocked");
            })
        }
        var messageBlock = document.getElementById("message-block");
        messageBlock.innerHTML += "<p " + style + ">" + message + "</p>";
        messageBlock.scrollTop = messageBlock.scrollHeight;
        if(this.enemy.ships == 0) this.gameOver();
    }

    enemyShot(){
        ++this.enemy.numberOfShots;
        var [row, col] = this.enemy.getNextTarget();
        var target = document.getElementById("my-"+row+"-"+col);
        var message, style;
        if(this.me.map[row][col] == 0){
            target.classList.add("miss");
            document.getElementById("turn").innerHTML = "Your turn!";
            message = "<strong>Computer</strong> shot " + row + LETTERS[col] + ", miss!";
            style = "style='color: red;'";
            this.enemy.miss(row, col);
            clearInterval(this.interval);
            document.getElementById("enemy-map").classList.remove("blocked");
        }
        else{
            this.enemy.prevHit = [true, row, col];
            target.removeChild(target.firstChild);
            target.classList.add("hit");
            message = "<strong>Computer</strong> shot " + row + LETTERS[col] + ", hit!";
            style = "style='color: green;'";
            ++this.enemy.numberOfHits;
            --this.me.ships;
            this.enemy.hit(row, col);
        }
        var messageBlock = document.getElementById("message-block");
        messageBlock.innerHTML += "<p " + style + ">" + message + "</p>";
        messageBlock.scrollTop = messageBlock.scrollHeight;
        if(this.me.ships == 0){
            clearInterval(this.interval);
            this.gameOver();
        }
    }

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
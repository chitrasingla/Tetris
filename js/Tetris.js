'use strict';

//Retrieve css for canvas
var canvas = document.querySelector('canvas');

//This will remove focus from all buttons as soon as they are focused.
//This will prevent spacebar from ever activating the dark toggle button
document.querySelectorAll("button").forEach( function(item) {
    item.addEventListener('focus', function() {
        this.blur();
    })
})

//set canvas size
canvas.width = 900;
canvas.height = 550;

//creation of a  two-dimensional rendering context(Drawing plane).
var g = canvas.getContext('2d');

// shift reference to (400, -105)
//g.translate(400, -105); 

//reference co-ordinates
var X=400,  Y=-105;

//moves with their change in x and y coordinates
var right = { x: 1, y: 0 };
var down = { x: 0, y: 1 };
var left = { x: -1, y: 0 };
//var down = { x: 0, y: -1};

//playing grid values
var EMPTY = -1;
var BORDER = -2;

//store falling shape data
var fallingShape;

//store next shape data for preview box
var nextShape;

//dimensions of playing grid
var dim = 640;

//number of rows
var nRows = 19;

//number of columns
var nCols = 15;

// blocksize of grid
var blockSize = 30;

//primary font setting 
var mainFont = 'bold 48px monospace';

//secondary font setting
var smallFont = 'bold 18px monospace';

//colours for playing pieces
var colours = ['green', 'red', 'blue', 'purple', 'orange', 'blueviolet', 'magenta'];

//falling object starting position
var topMargin = Y+107;
var leftMargin = X+20;

//coordinates for title text
var titleX = 230;
var titleY = 160;

//coordinates for message text
var clickX = 120;
var clickY = 400;

//preview shape coordinates
var previewCenterX = -280;
var previewCenterY = 390;

//playing grid
var gridRect = { x: X+46, y: Y+107, w: 398, h: 540 };
var outerRect = { x: X+5, y: Y+55, w: 400, h: 630 };

//preview shape grid
var previewRect = { x: 5, y: 260, w: 280, h: 280 };

//title box settings
var titleRect = { x: X+100, y: 95, w: 252, h: 100 };

//message box settings
var clickRect = { x: X+50, y: Y+425, w: 252, h: 40 };

//set border colour
var squareBorder = 'white';

//set title colour
var titlebgColour = 'black';

//set text colour
var textColour  = 'white';

//function to change colour in accordance to the playing mode
function set_Colour(){
    
    //check whether the switch is set to Dark Mode
    var isChecked=document.getElementById("togBtn").checked;

    if(isChecked){
        //if switch is place at dark mode
        
        //set text colour to white
        textColour='white';
        
        //set background colour to black
        titlebgColour='black';    
    }else{
        //if switch is placed at light mode
        
        //set text colour to black
        textColour='black';
        
        //set background colour to white
        titlebgColour='white';
    }
}

//store background colour
var bgColour = '#DDEEFF';

//store grid colour
var gridColour = '#BECFEA';

//store border colour 
var gridBorderColour = '#7788AA';

//store stroke colors
//The stroke() method actually draws the path you have defined with all those moveTo() and lineTo() methods.
var largeStroke = 5;
var smallStroke = 2;

//to store whether it is the first session of game or not
var new_session=false;

// position of falling shape
var fallingShapeRow;
var fallingShapeCol;

//set movement values for keyboard key input
var keyDown = false;
var fastDown = false;

//array to store playing grid values whether,
//filled or vacant 
var grid = [];

//to store scoreboard details
var scoreboard = new Scoreboard();

//to solve the problem of multiple entries
var lock=0;
//shapes present 
var Shapes = {
    ZShape: [[0, -1], [0, 0], [-1, 0], [-1, 1]],
    SShape: [[0, -1], [0, 0], [1, 0], [1, 1]],
    IShape: [[0, -1], [0, 0], [0, 1], [0, 2]],
    TShape: [[-1, 0], [0, 0], [1, 0], [0, 1]],
    Square: [[0, 0], [1, 0], [0, 1], [1, 1]],
    LShape: [[-1, -1], [0, -1], [0, 0], [0, 1]],
    JShape: [[1, -1], [0, -1], [0, 0], [0, 1]]
};

//track the user game play
addEventListener('keydown', function (event) {
    //check the key pressed by the user
    
    if (!keyDown) {
        //if keydown is false set to true
        keyDown = true;

        //check status of game
        if (scoreboard.isGameOver()){
            //if game is over draw the board
            draw();
            return;
        }

        //controls permitted in the game
        switch (event.key) {
            //if input key is 'w' or 'ArrowUp'
            case 'w':
            case 'ArrowUp':
                //check whether we can rotate the falling shape or not (square piece cannot rotate),
                //if true rotate the falling shape
                if (canRotate(fallingShape))
                    rotate(fallingShape);
                break;

            //if input key is 'a' or 'ArrowLeft'
            case 'a':
            case 'ArrowLeft':
                //check whether we can move the falling shape towards left or not,
                //if true move the falling shape to left
                if (canMove(fallingShape, left))
                    move(left);
                break;

            case 'd':
            case 'ArrowRight':
                //check whether we can move the falling shape towards right or not,
                //if true move the falling shape to right
                if (canMove(fallingShape, right))
                    move(right);
                break;

            case 's':
            case 'ArrowDown':
                //if (!fastDown) 
                {
                    //move the falling shape down faster
                    //fastDown = true;
                    //check whether we can move the falling shape towards down or not,
                    //if true move the falling shape to down
                    if (canMove(fallingShape, down)) {
                        move(down);
                //        draw();
                    }
                    else
                        shapeHasLanded();
                }
        }
        draw();
    }
});

//capture the key input
document.body.onkeyup = function(e){
    //check whether space bar is pressed
    if(e.keyCode == 32){
 
        if(!lock){

	        //if true start new game
	        startNewGame();
        }
    }
}

//check whether the key up button is used for game play
addEventListener('keyup', function () {
    keyDown = false;
    fastDown = false;
});

//function to check if the figure can rotate or not
function canRotate(s) {
    //if square shape return false
    if (s === Shapes.Square)
        return false;

    //pos array to store the shape data
    var pos = new Array(4);
    //store the shape data in pos array
    for (var i = 0; i < pos.length; i++) {
        pos[i] = s.pos[i].slice();
    }

    //rotating the shape if not square
    pos.forEach(function (row) {
        var tmp = row[0];
        row[0] = row[1];
        row[1] = -tmp;
    });

    //change grid values after rotation of shape
    return pos.every(function (p) {
        var newCol = fallingShapeCol + p[0];
        var newRow = fallingShapeRow + p[1];
        return grid[newRow][newCol] === EMPTY;
    });
}

//function to rotate the falling shape
function rotate(s) {
    //check if the falling shape is square or not
    if (s === Shapes.Square)
        return;
    //rotating the shape if not square
    s.pos.forEach(function (row) {
        var tmp = row[0];
        row[0] = row[1];
        row[1] = -tmp;
    });
}

//function to move the shape in the desired direction 
function move(dir) {
    fallingShapeRow += dir.y;
    fallingShapeCol += dir.x;
}

//function to check if the shape can move
function canMove(s, dir) {

    //change grid values after rotation of shape
    return s.pos.every(function (p) {
        var newCol = fallingShapeCol + dir.x + p[0];
        var newRow = fallingShapeRow + dir.y + p[1];
        return grid[newRow][newCol] === EMPTY;
    });
}

//function to compute the status of playing grid after the shape is placed at bottom
function shapeHasLanded() {
    
    //fix the falling shape
    addShape(fallingShape);

    //check if the falling shape breached outside the playing grid
    if (fallingShapeRow < 2) {

        //set game over to true
        scoreboard.setGameOver();

        //set the score to topscore, if it is the maximun
        scoreboard.setTopscore();
    } else {

        //remove the completely filled rows of grid 
        scoreboard.addLines(removeLines());
    }

    //select the nextShape as the fallingShape
    selectShape();
}

//function to count and remove completely filled rows from grid
function removeLines() {

    //to store count of filled grid rows
    var count = 0;

    //iterate over the playing grid
    for (var r = 0; r < nRows - 1; r++) {

        //for every row check column value
        for (var c = 1; c < nCols - 1; c++) {

            //if grid is empty implies the row is not completely filled
            //check next row
            if (grid[r][c] === EMPTY)
                break;

            //increase count if filled rows
            if (c === nCols - 2) {
                count++;

                //remove the filled row
                removeLine(r);
            }
        }
    }

    //return the number of filled rows
    return count;
}

//function to remove line
function removeLine(line) {

    //iterate the column of desired row and set to empty
    for (var c = 0; c < nCols; c++)
        grid[line][c] = EMPTY;

    //push the above grid rows' values down by one row
    for (var c = 0; c < nCols; c++) {
        for (var r = line; r > 0; r--)
            grid[r][c] = grid[r - 1][c];
    }
}

//function to fix the falling shape
function addShape(s) {
    s.pos.forEach(function (p) {
        grid[fallingShapeRow + p[1]][fallingShapeCol + p[0]] = s.ordinal;
    });
}

//function to operate on shape
function Shape(shape, o) {

    //store shape values
    this.shape = shape;

    //store shape position, initialise to null
    this.pos = this.reset();

    //store ordinal number
    this.ordinal = o;
}

//function to choose randon shape for nextShape
function getRandomShape() {

    //array of values stored in Shapes
    var keys = Object.keys(Shapes);

    //choose a random number
    //math.random returns a value in between 0 and 1, both inclusive.
    var ord = Math.floor(Math.random() * keys.length);
    
    // retrieve the shape values 
    var shape = Shapes[keys[ord]];
    
    //return the shape
    return new Shape(shape, ord);
}

//adding additional property to the shape object
Shape.prototype.reset = function () {

    //store the shape data
    this.pos = new Array(4);

    //store values in pos array
    for (var i = 0; i < this.pos.length; i++) {
        this.pos[i] = this.shape[i].slice();
    }

    //return pos array
    return this.pos;
}

//function to select shape
function selectShape() {

    //iniitial column and row of the object
    fallingShapeRow = 1;
    fallingShapeCol = 7;

    // advance to the next shape displayed in the side panel
    fallingShape = nextShape;
    
    //choose the next shape(it is global variable)
    nextShape = getRandomShape();
    
    //if fallingshape present reset it
    if (fallingShape != null) {
        fallingShape.reset();
    }
}

//class for scoreboard
function Scoreboard() {

    //maximun level that is allowed
    this.MAXLEVEL = 9;

    //to store level data
    var level = 0;

    //to store lines data
    var lines = 0;
    var count_lines=0;

    //to store score of current game
    var score = 0;

    //to store topscore until now
    var topscore = 0;

    //to store status of game
    var gameOver = true;

    //function to reset the variables
    this.reset = function () {
        this.setTopscore();
        level = lines = score = count_lines = 0;
        gameOver = false;
    }

    //function to set game status
    this.setGameOver = function () {
        gameOver = true;
    }

    //function to retrieve game status
    this.isGameOver = function () {
        return gameOver;
    }

    //function to set topscore
    this.setTopscore = function () {
        if (score > topscore) {
            topscore = score;
        }
    }

    //function to retrieve topscore
    this.getTopscore = function () {
        if (score > topscore) {
            topscore = score;
        }
        return topscore;
    }

    //function to set speed of falling in accordance to level
    this.getSpeed = function () {

        switch (level) {
            case 0: return 700;
            case 1: return 600;
            case 2: return 500;
            case 3: return 400;
            case 4: return 350;
            case 5: return 300;
            case 6: return 250;
            case 7: return 200;
            case 8: return 150;
            case 9: return 100;
            default: return 100;
        }
    }

    //function to increase score
    this.addScore = function (sc) {
        score += sc;
    }

    //function to increase the score according to the line 
    this.addLines = function (line) {

        switch (line) {
            case 1:
                this.addScore(10);
                break;
            case 2:
                this.addScore(30);
                break;
            case 3:
                this.addScore(50);
                break;
            case 4:
                this.addScore(70);
                break;
            default:
                return;
        }

        //increase line
        lines += line;
        count_lines += line;

        //if line more than 10, advance to next level
        //if (lines/10 > level) {
            this.addLevel();
        //}
    }

    //function to increase level
    this.addLevel = function () {
       // lines %= 10;
        if (level < this.MAXLEVEL) {
            var x = score/120 ;
            x = parseInt(x);
            level = x%10;
        }
    }

    //function to retrieve level
    this.getLevel = function () {
        return level;
    }

    //function to retrieve line
    this.getLines = function () {
        return count_lines;
    }

    //function to retrieve score
    this.getScore = function () {
        return score;
    }
}

//function to draw the title, message, falling shape and playing grid
function draw() {

    //clear a rectange of desired size
    g.clearRect(0, 0, canvas.width, canvas.height);

    //draw the filled cells of grid with other utilities
    drawUI();

    //draw the title, message and falling shape according to the status of game
    if (scoreboard.isGameOver()) {

        //fill the grid with gridcolour
    	fillRect(gridRect, gridColour);
        
        //check if first session
        if(new_session)
            drawGameOverScreen();
        else
            drawStartScreen();
    } 
    else {
        drawFallingShape();
        //tells its not the first game of session
        new_session=true;
    }
}


//function to draw start screen
function drawStartScreen() {
    
    //fill colour to titlebox and message box
    fillRect(titleRect, titlebgColour);
    fillRect(clickRect, titlebgColour);

    //set text colour
    g.fillStyle = textColour;

    //set font for title
    g.font = mainFont;
    
    //write title
    g.fillText('NEW GAME', titleX+290, titleY,);

    //set font for message
    g.font = smallFont;

    //write message
    g.fillText('Press Space To Start', clickX+360, clickY-50);
}

//function to draw gameover screen
function drawGameOverScreen(){

	//remove lock
	lock=0;

    //fill colour to titlebox and message box
    fillRect(titleRect, titlebgColour);
    fillRect(clickRect, titlebgColour);

    //set text colour
    g.fillStyle = textColour;

    //set font for title
    g.font = mainFont;

    //write title
    g.fillText('GAME OVER', titleX+275, titleY,);

    //set font for message
    g.font = smallFont;

    //write message
    g.fillText('Press Space To Start', clickX+360, clickY-50);  

    if(new_session){

		//add the score to database
		loadDoc();	
	}
}

//function to load variable and send it to php
function loadDoc() {

  //player score
  var player={};
  player.score = scoreboard.getScore();

  $.ajax({
  	url:"save_score.php",
  	method: "post",
  	data: player,
  })
}

//function to fill colour to rectangle box
function fillRect(r, colour) {

    //set bgcolour
    g.fillStyle = colour;

    //fill colour to rectangle box
    g.fillRect(r.x, r.y, r.w, r.h);
}

//function to draw rectangle or grid border
function drawRect(r, colour) {

    //set stroke colour
    g.strokeStyle = colour;

    //draw stroke border
    g.strokeRect(r.x, r.y, r.w, r.h);
}

//function to draw square or grid cell
function drawSquare(colourIndex, r, c) {

    //store blocksize
    var bs = blockSize;

    //set colour
    g.fillStyle = colours[colourIndex];

    //fill colour in square box
    g.fillRect(leftMargin + c * bs, topMargin + r * bs, bs, bs);

    //set line width
    g.lineWidth = smallStroke;

    //set box border
    g.strokeStyle = squareBorder;

    //draw stroke
    g.strokeRect(leftMargin + c * bs, topMargin + r * bs, bs, bs);
}

// draw the game utilities 
function drawUI() {

    // background
    //fillRect(outerRect, bgColour);
    fillRect(gridRect, gridColour);

    // iterate the cells in the grid
    for (var r = 0; r < nRows; r++) {

        //for every row
        for (var c = 0; c < nCols; c++) {

            //store value cell
            var idx = grid[r][c];
            
            if (idx > EMPTY)

                //draw the cell
                drawSquare(idx, r, c);
        }
    }

    //set line width
    g.lineWidth = largeStroke;

    //the borders of grid and preview panel
    drawRect(gridRect, gridBorderColour);
    drawRect(previewRect, gridBorderColour);

    // scoreboard
    //set colour
    g.fillStyle = textColour;
    
    //set font
    g.font = smallFont;
    
    //draw text for scoreboard details
    g.fillText(scoreboard.getTopscore(), 150, 36);
    g.fillText(scoreboard.getLevel(), 150, 99 );
    g.fillText(scoreboard.getLines(), 150, 164 );
    g.fillText(scoreboard.getScore(), 150, 227 );

    // preview panel

    //next shape
    var minX = 5, minY = 5, maxX = 0, maxY = 0;
    nextShape.pos.forEach(function (p) {
        minX = Math.min(minX, p[0]);
        minY = Math.min(minY, p[1]);
        maxX = Math.max(maxX, p[0]);
        maxY = Math.max(maxY, p[1]);
    });

    //to store coordinates
    var cx = previewCenterX - ((minX + maxX + 1) / 2.0 * blockSize);
    var cy = previewCenterY - ((minY + maxY + 1) / 2.0 * blockSize);

    //move to cx,cy
    g.translate(cx, cy);

    nextShape.shape.forEach(function (p) {
        drawSquare(nextShape.ordinal, p[1], p[0]);
    });

    //move to -cx, -cy
    g.translate(-cx, -cy);
}

//function to draw fallingshape
function drawFallingShape() {

	if(!lock){
		lock=1;
	}
    //store ordinal number of shape
    var idx = fallingShape.ordinal;

    //draw cells in grid according to shape
    fallingShape.pos.forEach(function (p) {
        drawSquare(idx, fallingShapeRow + p[1], fallingShapeCol + p[0]);
    });
}

//function to display animated movement of playing grid
function animate(lastFrameTime) {
    
    //store animation frame time
    var requestId = requestAnimationFrame(function () {
        animate(lastFrameTime);
    });

    //store time
    var time = new Date().getTime();

    //store speed of falling shape
    var delay = scoreboard.getSpeed();

    if (lastFrameTime + delay < time) {

        //check game status
        if (!scoreboard.isGameOver()) {

            //check movement of falling shape
            if (canMove(fallingShape, down)) {
                move(down);
            } else {
                shapeHasLanded();
            }

            //draw the falling grid
            draw();

            //set frame time
            lastFrameTime = time;

        } else {

            //cancel animation 
            cancelAnimationFrame(requestId);
        }
    }
}

//function invoked on new game
function startNewGame() {
        
    //set the grid cells to empty
    initGrid();

    //select the nextshape as falling shape
    selectShape();

    //reset the scoreboard
    scoreboard.reset();

    //start animation
    animate(-1);
}

//function to initialise the playing grid
function initGrid() {

    //function to fill the grid cells with desired value
    function fill(arr, value) {
        for (var i = 0; i < arr.length; i++) {
            arr[i] = value;
        }
    }

    //iterate cells of the playing grid
    for (var r = 0; r < nRows; r++) {
        
        //for every row, initialise a new array
        //to store column of grid
        grid[r] = new Array(nCols);

        //Initialise the grid as empty,fill the cells with empty value
        fill(grid[r], EMPTY);

        //fill the cells at border with border value
        for (var c = 0; c < nCols; c++) {
            if (c === 0 || c === nCols - 1 || r === nRows - 1)
                grid[r][c] = BORDER;
        }
    }
}

//function to intialise game play
function init() {

    //initialise the tetris box/grid
    initGrid();
    
    //selecting the shape
    selectShape();
    
    //drawing the playing console
    draw();
    
}

//start the game page
init();

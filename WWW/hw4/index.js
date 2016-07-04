// inner variables
var canvas, ctx;

// images
var backgroundImage;
var oRocketImage;
var oExplosionImage;
var introImage;
var oEnemyImage;
var oEnemy1Image;
var oEnemy2Image;

var pauseImage;

var iBgShiftY = 9300; //10000 (level length) - 700 (canvas height)
var bPause = true; // game pause
var plane = null; // plane object

var rockets = []; // array of rockets
var enemies = []; // array of enemies
var enemies1 = [];
var enemies2 = [];

var explosions = []; // array of explosions

var planeW = 200; // plane width
var planeH = 110; // plane height

var iEnemyW = 128; // enemy width
var iEnemyH = 128; // enemy height
var iEnemy1W = 100; 
var iEnemy1H = 46;
var iEnemy2W = 100; 
var iEnemy2H = 46;
var person = '';

var iRocketSpeed = 10; // initial rocket speed
var iEnemySpeed = 5; // initial enemy speed
var pressedKeys = []; // array of pressed keys
var iScore = 0; // total score
var iLife = 100; // total life of plane
var iDamage = 10; // damage per enemy plane
var enTimer = null; // random timer for a new enemy
var en1Timer = null;
var en2Timer = null;
var drawscenetimer = null;
// -------------------------------------------------------------


    var selectplane =  0;
   
    function rule(){
        
        alert('No.1Choose the plane and press "OK" to start.\nNo.2Keyboard reight,left,up and down to move.\nNo.3Press "A" to attack enemy.\nNo.4Press "p" to pause game.\nNo.5Press "r" to return game.\nNo.6If your lifepoint is zero,GAME OVER.');
        
    }
    function createcookie(){
        var temp = iScore*10;
        var temp2 = 0;
        var tempname = person;
        var tempname2 = '';
        $('#okbtn').css("visibility","visible");
        $('#rankbtn').css("visibility","visible");
        for(var i=1;i<11;i++)
        {
            if($.cookie('score'+i))
            {
                if($.cookie('score'+i) < temp)
                {
                    temp2 = temp;
                    temp =  $.cookie('score'+i) ;
                    $.cookie('score'+i, temp2,{ path:'/', expires: 365 }) ;
                    tempname2 = tempname;
                    tempname = $.cookie('rank'+i) ;
                    $.cookie('rank'+i, tempname2,{ path:'/', expires: 365 }) ;
                   
                }

            }
            else
            {   
                
                $.cookie('score'+i, temp,{ path:'/', expires: 365 }) ;
                $.cookie('rank'+i, tempname,{ path:'/', expires: 365 }) ;
                break;
            }
        }
        
    }
    function closescore(){
        
        $("#rankhistory").hide();
        
    }
    function rank(){
        $("#rankhistory").show();
        for(var i=1;i<11;i++)
        {
            if($.cookie('rank'+i))
            {
                
                document.getElementById("player"+i).innerHTML=$.cookie('rank'+i);
                document.getElementById("score"+i).innerHTML=$.cookie('score'+i);
            }
            else{
                document.getElementById("player"+i).innerHTML='XXX';
                document.getElementById("score"+i).innerHTML=0;
                
            }
        }
        
    }
    function selectcheck(n){
    var selimg = '#img'+n;
    var selbtn = '#btn'+n;
    if( selectplane !=  0){
    var removeimg = '#img'+selectplane;
    var removebtn = '#btn'+selectplane;
    $(removeimg).attr("src",selectplane+'.png');
    $(removeimg).animate({height: "80px",width:"80px"}).delay(100).animate({height: "100px",width:"100px"});
    $(removebtn).css({"border":"3px #FFFFFF solid"});
    }
    $(selimg).attr("src",n+'yes.png');
    $(selimg).animate({height: "80px",width:"80px"}).delay(100).animate({height: "100px",width:"100px"});
    $(selbtn).css({"border":"3px #00DDDD solid"});
    selectplane = n;
    document.getElementById("okbtn").disabled = false;
    
     }
     
     function gamestart(){
        $('#okbtn').css("visibility","hidden");
         $('#rankbtn').css("visibility","hidden");       
        iBgShiftY = 9300; //10000 (level length) - 700 (canvas height)
        bPause = true; // game pause
        plane = null; // plane object

        rockets = []; // array of rockets
        enemies = []; // array of enemies
        enemies1 = [];
        enemies2 = [];
        pressedKeys = []; // array of pressed keys
        iScore = 0; // total score
        iLife = 100; // total life of plane
        explosions = []; // array of explosions
        clearInterval(en1Timer);
        clearInterval(en2Timer);
        clearInterval(enTimer);
        clearInterval(drawscenetimer);
         
        
        
        
        var planeimgurl = selectplane + '.png';
        // initialization of plane
        var oPlaneImage = new Image();
        oPlaneImage.src = planeimgurl;
        oPlaneImage.onload = function() {
            plane = new Plane(canvas.width / 2, canvas.height - 100, planeW, planeH, oPlaneImage);
        }
            bPause = false;

            // start main animation
            drawscenetimer = setInterval(drawScene, 30); // loop drawScene

            // and add first enemy
            addEnemy();
            addEnemy1();
            addEnemy2();
        
            
     }
// objects :
function Plane(x, y, w, h, image) {
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
    this.image = image;
    this.bDrag = false;
}
function Rocket(x, y, w, h, speed, image) {
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
    this.speed = speed;
    this.image = image;
}
function Enemy(x, y, w, h, speed, image) {
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
    this.speed = speed;
    this.image = image;
}


function Explosion(x, y, w, h, sprite, image) {
    this.x = x;
    this.y = y;
    this.w = w;
    this.h = h;
    this.sprite = sprite;
    this.image = image;
}
// -------------------------------------------------------------
// get random number between X and Y
function getRand(x, y) {
    return Math.floor(Math.random()*y)+x;
}

// Display Intro function
function displayIntro() {
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    ctx.drawImage(introImage, 0, 0,700, 700);
}

// Draw Main scene function
function drawScene() {

    if (! bPause) {
        iBgShiftY -= 2; // move main ground
        if (iBgShiftY < 5) { // Finish position
            bPause = true;

            // draw score
            ctx.font = '40px Verdana';
            ctx.fillStyle = '#fff';
            ctx.fillText('Finish, your score: ' + iScore * 10 + ' points', 50, 200);
            ctx.fillText('Press R to restart', 50, 240);
            person = prompt("You get "+iScore*10+" point(s). Please enter your name");
            createcookie();
            return;
        }

        // process pressed keys (movement of plane)
        processPressedKeys();

        // clear canvas
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

        // draw background   drawImage(img,sx,sy,swidth,sheight,x,y,width,height);
        ctx.drawImage(backgroundImage, 0, 0 , 700, 700);

        // draw plane
        ctx.drawImage(plane.image, plane.x - plane.w/2, plane.y - plane.h/2, plane.w, plane.h);

        // draw rockets
        if (rockets.length > 0) {
            for (var key in rockets) {
                if (rockets[key] != undefined) {
                    ctx.drawImage(rockets[key].image, rockets[key].x, rockets[key].y);
                    rockets[key].y -= rockets[key].speed;

                    // if a rocket is out of screen - remove it
                    if (rockets[key].y < 0) {
                        delete rockets[key];
                    }
                }
            }
        }

        // draw explosions
        if (explosions.length > 0) {
            for (var key in explosions) {
                if (explosions[key] != undefined) {
                    // display explosion sprites
                    ctx.drawImage(explosions[key].image, explosions[key].sprite*explosions[key].w, 0, explosions[key].w, explosions[key].h, explosions[key].x - explosions[key].w/2, explosions[key].y - explosions[key].h/2, explosions[key].w, explosions[key].h);
                    explosions[key].sprite++;

                    // remove an explosion object when it expires
                    if (explosions[key].sprite > 10) {
                        delete explosions[key];
                    }
                }
            }
        }

        // draw enemies drawImage(img,sx,sy,swidth,sheight,x,y,width,height);
        if (enemies.length > 0) {
            for (var ekey in enemies) {
                if (enemies[ekey] != undefined) {
                    ctx.drawImage(enemies[ekey].image, enemies[ekey].x, enemies[ekey].y,iEnemyW,iEnemyH);
                    enemies[ekey].y -= enemies[ekey].speed;

                    // remove an enemy object if it is out of screen
                    if (enemies[ekey].y > canvas.height) {
                        delete enemies[ekey];
                    }
                }
            }
        }
        //enemies1
        if (enemies1.length > 0) {
            for (var ekey in enemies1) {
                if (enemies1[ekey] != undefined) {
                    ctx.drawImage(enemies1[ekey].image, enemies1[ekey].x, enemies1[ekey].y);
                    enemies1[ekey].x -= enemies1[ekey].speed;

                    // remove an enemy object if it is out of screen
                    if (enemies1[ekey].x > canvas.width) {
                        delete enemies1[ekey];
                    }
                }
            }
        }
        //enemies2
        if (enemies2.length > 0) {
            for (var ekey in enemies2) {
                if (enemies2[ekey] != undefined) {
                    ctx.drawImage(enemies2[ekey].image, enemies2[ekey].x, enemies2[ekey].y);
                    enemies2[ekey].x += enemies2[ekey].speed;

                    // remove an enemy object if it is out of screen
                    if (enemies2[ekey].x < 0) {
                        delete enemies2[ekey];
                    }
                }
            }
        }

        if (enemies.length > 0) {
            for (var ekey in enemies) {
                if (enemies[ekey] != undefined) {

                    // collisions with rockets
                    if (rockets.length > 0) {
                        for (var key in rockets) {
                            if (rockets[key] != undefined) {
                                if (rockets[key].y < enemies[ekey].y + enemies[ekey].h/2 && rockets[key].y > enemies[ekey].y  && rockets[key].x > enemies[ekey].x && rockets[key].x + rockets[key].w < enemies[ekey].x + enemies[ekey].w) {
                                    explosions.push(new Explosion(enemies[ekey].x + enemies[ekey].w / 2, enemies[ekey].y + enemies[ekey].h / 2, 120, 120, 0, oExplosionImage));
                                    Hit.play();
                                    // delete enemy, rocket, and add +1 to score
                                    delete enemies[ekey];
                                    delete rockets[key];
                                    iScore++;
                                    break;
                                }
                            }
                        }
                    }

                    // collisions with plane
                    if (enemies[ekey] != undefined) {
                        if (plane.y - plane.h/2 < enemies[ekey].y + enemies[ekey].h/2 && plane.y + plane.h/2 > enemies[ekey].y  && plane.x - plane.w/2 < enemies[ekey].x + enemies[ekey].w && plane.x + plane.w/2 > enemies[ekey].x) {
                            explosions.push(new Explosion(enemies[ekey].x + enemies[ekey].w / 2, enemies[ekey].y + enemies[ekey].h / 2, 120, 120, 0, oExplosionImage));
                            Hit.play();
                            // delete enemy and make damage
                            delete enemies[ekey];
                            iLife -= iDamage;

                            if (iLife <= 0) { // Game over
                                bPause = true;

                                // draw score
                                ctx.font = '38px Verdana';
                                ctx.fillStyle = '#fff';
                                ctx.fillText('Game over, your score: ' + iScore * 10 + ' points', 25, 200);
                                ctx.fillText('Press R to restart', 25, 240);
                                  person = prompt("You get "+iScore*10+" point(s). Please enter your name");
                                  createcookie();
                                return;
                            }
                        }
                    }
                }
            }
        }
        //enemy1
        if (enemies1.length > 0) {
            for (var ekey in enemies1) {
                if (enemies1[ekey] != undefined) {

                    // collisions with rockets
                    if (rockets.length > 0) {
                        for (var key in rockets) {
                            if (rockets[key] != undefined) {
                                if (rockets[key].y < enemies1[ekey].y + enemies1[ekey].h/2 && rockets[key].y > enemies1[ekey].y && rockets[key].x > enemies1[ekey].x-30 && rockets[key].x + rockets[key].w < enemies1[ekey].x + enemies1[ekey].w) {
                                    explosions.push(new Explosion(enemies1[ekey].x + enemies1[ekey].w / 2, enemies1[ekey].y + enemies1[ekey].h / 2, 120, 120, 0, oExplosionImage));
                                    Hit.play();
                                    // delete enemy, rocket, and add +1 to score
                                    delete enemies1[ekey];
                                    delete rockets[key];
                                    iScore++;
                                    break;
                                }
                            }
                        }
                    }

                    // collisions with plane
                    if (enemies1[ekey] != undefined) {
                        if (plane.y - plane.h/2 < enemies1[ekey].y + enemies1[ekey].h/2 && plane.y + plane.h/2 > enemies1[ekey].y  && plane.x - plane.w/2 < enemies1[ekey].x + enemies1[ekey].w && plane.x + plane.w/2 > enemies1[ekey].x) {
                            explosions.push(new Explosion(enemies1[ekey].x + enemies1[ekey].w / 2, enemies1[ekey].y + enemies1[ekey].h / 2, 120, 120, 0, oExplosionImage));
                            Hit.play();
                            // delete enemy and make damage
                            delete enemies1[ekey];
                            iLife -= iDamage;

                            if (iLife <= 0) { // Game over
                                bPause = true;

                                // draw score
                                ctx.font = '38px Verdana';
                                ctx.fillStyle = '#fff';
                                ctx.fillText('Game over, your score: ' + iScore * 10 + ' points', 25, 200);
                                ctx.fillText('Press R to restart', 25, 240);
                                 person = prompt("You get "+iScore*10+" point(s). Please enter your name");
                                 createcookie();
                                return;
                            }
                        }
                    }
                }
            }
        }
        
        
        //enemy2
        if (enemies2.length > 0) {
            for (var ekey in enemies2) {
                if (enemies2[ekey] != undefined) {

                    // collisions with rockets
                    if (rockets.length > 0) {
                        for (var key in rockets) {
                            if (rockets[key] != undefined) {
                                if (rockets[key].y < enemies2[ekey].y + enemies2[ekey].h/2 && rockets[key].y > enemies2[ekey].y && rockets[key].x > enemies2[ekey].x && rockets[key].x + rockets[key].w < enemies2[ekey].x + enemies2[ekey].w+30) {
                                    explosions.push(new Explosion(enemies2[ekey].x + enemies2[ekey].w / 2, enemies2[ekey].y + enemies2[ekey].h / 2, 120, 120, 0, oExplosionImage));
                                    Hit.play();
                                    // delete enemy, rocket, and add +1 to score
                                    delete enemies2[ekey];
                                    delete rockets[key];
                                    iScore++;
                                    break;
                                }
                            }
                        }
                    }

                    // collisions with plane
                    if (enemies2[ekey] != undefined) {
                        if (plane.y - plane.h/2 < enemies2[ekey].y + enemies2[ekey].h/2 && plane.y + plane.h/2 > enemies2[ekey].y  && plane.x - plane.w/2 < enemies2[ekey].x + enemies2[ekey].w && plane.x + plane.w/2 > enemies2[ekey].x) {
                            explosions.push(new Explosion(enemies2[ekey].x + enemies2[ekey].w / 2, enemies2[ekey].y + enemies2[ekey].h / 2, 120, 120, 0, oExplosionImage));
                            Hit.play();
                            // delete enemy and make damage
                            delete enemies2[ekey];
                            iLife -= iDamage;

                            if (iLife <= 0) { // Game over
                                bPause = true;

                                // draw score
                                ctx.font = '38px Verdana';
                                ctx.fillStyle = '#fff';
                                ctx.fillText('Game over, your score: ' + iScore * 10 + ' points', 25, 200);
                                ctx.fillText('Press R to restart', 25, 240);
                                 person = prompt("You get "+iScore*10+" point(s). Please enter your name");
                                 createcookie();
                                return;
                            }
                        }
                    }
                }
            }
        }
        
        
        
        // display life and score
        ctx.font = '14px Verdana';
        ctx.fillStyle = '#fff';
        ctx.fillText('Life: ' + iLife + ' / 100', 50, 660);
        ctx.fillText('Score: ' + iScore * 10, 50, 680);
        var finalload = 10000 - iBgShiftY+6;
        ctx.fillText('Final: ' + finalload+'/10000', 50, 640);
    }
}

// Process Pressed Keys function
function processPressedKeys() {
    if (pressedKeys[37] != undefined) { // 'Left' key

        if (plane.x - plane.w / 2 > 10) {
            plane.x -= 7;
        }
    }
    else if (pressedKeys[39] != undefined) { // 'Right' key

        if (plane.x + plane.w / 2 < canvas.width - 10) {
            plane.x += 7;
        }
    }
        else if (pressedKeys[38] != undefined) { // 'Right' key

        if (plane.y - plane.h / 2 > 10) {
            plane.y -= 7;
        }
    }
      else if (pressedKeys[40] != undefined) { // 'Right' key

        if (plane.y + plane.h / 2 < canvas.height - 10) {
            plane.y += 7;
        }
    }

    }


// Add Enemy function (adds a new enemy randomly)
function addEnemy() {
    clearInterval(enTimer);
    if(!bPause){
        var randX = getRand(0, canvas.width - iEnemyW);
        enemies.push(new Enemy(randX, 0, iEnemyW, iEnemyH, - iEnemySpeed, oEnemyImage));
    }
    var interval = getRand(1000, 4000);
    enTimer = setInterval(addEnemy, interval); // loop
}

function addEnemy1() {
    
    clearInterval(en1Timer);
    if(!bPause){
        var randY = getRand(0, canvas.height - planeH);
        enemies1.push(new Enemy(0, randY, iEnemy1W, iEnemy1H, - iEnemySpeed, oEnemy1Image));
    }
    var interval = getRand(1000, 4000);
    en1Timer = setInterval(addEnemy1, interval); // loop
}

function addEnemy2() {
    
    clearInterval(en2Timer);
    if(!bPause){
        var randY = getRand(0, canvas.height - planeH);
        enemies2.push(new Enemy(700, randY, iEnemy2W, iEnemy2H, - iEnemySpeed, oEnemy2Image));
    }
    var interval = getRand(1000, 4000);
    en2Timer = setInterval(addEnemy2, interval); // loop
}

function change_enemy(newenemyurl){
    oEnemyImage.src = newenemyurl;
    
}

// Main Initialization
$(function(){
    canvas = document.getElementById('scene');
    ctx = canvas.getContext('2d');

    // load background image
    backgroundImage = new Image();
    backgroundImage.src = 'background.jpg';
    backgroundImage.onload = function() {
    }
    backgroundImage.onerror = function() {
        console.log('Error loading the background image.');
    }

    introImage = new Image();
    introImage.src = 'startlogo.png';
    
    pauseImage = new Image();
    pauseImage.src = 'images/pause.png' 
   
    // initialization of empty rocket
    oRocketImage = new Image();
    oRocketImage.src = 'images/rocket.png';
    oRocketImage.onload = function() { }

    // initialization of explosion image
    oExplosionImage = new Image();
    oExplosionImage.src = 'images/explosion.png';
    oExplosionImage.onload = function() { }

    // initialization of empty enemy
    oEnemyImage = new Image();
    oEnemyImage.src = 'images/enemy.png';
    oEnemyImage.onload = function() { }
    
    oEnemy1Image = new Image();
    oEnemy1Image.src = 'images/enemy1.png';
    oEnemy1Image.onload = function() { }
    
    oEnemy2Image = new Image();
    oEnemy2Image.src = 'images/enemy2.png';
    oEnemy2Image.onload = function() { }


    $(window).keydown(function (evt){ // onkeydown event handle
        var pk = pressedKeys[evt.keyCode];
        if (! pk) {
            pressedKeys[evt.keyCode] = 1; // add all pressed keys into array
        }


      if (evt.keyCode == 65) { // 'A' button - add a rocket
            Shoot.play();
            rockets.push(new Rocket(plane.x - 16, plane.y - plane.h/2, 32, 32, iRocketSpeed, oRocketImage));
        }

      if (evt.keyCode == 80) {
             
            if(bPause){
               
                bPause = false;
                
            }
            else
            {
                
                bPause = true;
                ctx.drawImage(pauseImage,650, 0,50,50 );
                
            }
            
        }
        if (evt.keyCode == 82) {
        
        iBgShiftY = 9300; //10000 (level length) - 700 (canvas height)
        bPause = true; // game pause
        plane = null; // plane object

        rockets = []; // array of rockets
        enemies = []; // array of enemies
        enemies1 = [];
        enemies2 = [];
        pressedKeys = []; // array of pressed keys
        iScore = 0; // total score
        iLife = 100; // total life of plane
        explosions = []; // array of explosions
        clearInterval(en1Timer);
        clearInterval(en2Timer);
        clearInterval(enTimer);
        clearInterval(drawscenetimer);
         displayIntro();
          $('#okbtn').css("visibility","visible");
        $('#rankbtn').css("visibility","visible");
        }
        
    });

    $(window).keyup(function (evt) { // onkeyup event handle
        var pk = pressedKeys[evt.keyCode];
        if (pk) {
            delete pressedKeys[evt.keyCode]; // remove pressed key from array
        }

 
    });

    // when intro is ready - display it
    introImage.onload = function() {
        displayIntro(); // Display intro once
    }
});



var mic, fft, w, h, canvas;

function setup() {
  w = displayWidth;
  h = displayHeight;
  canvas = createCanvas(w,h);
  canvas.parent('visuals');
  noFill();
  mic = new p5.AudioIn();
  mic.start();
  fft = new p5.FFT();
  fft.setInput(mic);
}

// function mouseClicked() {
//     console.log(mic.listSources());
//     // mic.stop;
//     mic.setSource(4);
//     mic.start;
//     fft.setInput(mic);
// }

function draw() {
  // noCursor();
  fill(0,15,30,20);
  noStroke();
  rect(0,0,w,h);

  // var spectrum = fft.analyze();
  // beginShape();
  // stroke(0,0,128);
  // for (i = 0; i<spectrum.length; i++) {
  //   vertex(i, map(spectrum[i], 0, 255, h, 0) );
  // }
  // endShape();
 

  var waveform = fft.waveform();
  noFill();
  // push();
  // translate(w*0.5,h*0.5);
  beginShape();
  // var rad = radians( Math.asin(frameCount*0.0125)*90 );
  // rotate(rad);
  if ( !playing ) {
    stroke(100,0,70,120); // waveform color
  }
  else {
    var r = 32;
    var g = Math.abs(Math.round(Math.sin(frameCount*0.0125)*128))+64;
    var b = Math.abs(Math.round(Math.sin(frameCount*0.015)*192))+64;
    // console.log(r,g,b);
    stroke(r,g,b,120);
  }
  strokeWeight(3);
  for (var i = 0; i < waveform.length; i++){
    var x = map(i, 0, waveform.length, 0, w);
    var y = map( waveform[i], 0, 255, 0, h);
    if ( playing ) {
      vertex( x,y+( Math.sin(frameCount*0.0125)*360) );
    }
    else {
      vertex( x,y );
    }
    // vertex( x,waveform[i]+((h*0.5)-128) );
  }
  endShape();
  // pop();
}
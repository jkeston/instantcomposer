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

function draw() {
  fill(0,15,30,10);
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
  beginShape();
  stroke(100,0,70,120); // waveform color
  strokeWeight(3);
  for (var i = 0; i < waveform.length; i++){
    var x = map(i, 0, waveform.length, 0, w);
    var y = map( waveform[i], 0, 255, 0, h);
    vertex( x,y );
    // vertex( x,waveform[i]+((h*0.5)-128) );
  }
  endShape();
}

// get canvas from DOM
const canvas = document.querySelector('.congrats__canvas');

// create the confetti it return a function
const myConfetti = confetti.create(canvas, {
    resize: true,
    useWorker: true
  });

// execute the confetti witha config
let id = setInterval(() => {
    myConfetti({
      particleCount: 50,
      // particleCount: 1,
      // startVelocity: 0,
      spread: 160,
      origin: {
        x: Math.random(),
        y: (Math.random() * 1) - 0.2
       },
    });
}, 1000)

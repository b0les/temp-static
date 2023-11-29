$(document).ready(function () {
    var hintCounter = 1;

    setInterval(() => {
      $(".hint-text:nth-child(" + hintCounter + ")").fadeOut(999);
      hintCounter++;

      if (hintCounter === 5) {
        hintCounter = 1;
      }

      setTimeout(() => {
        $(".hint-text:nth-child(" + hintCounter + ")").fadeIn(500);
      }, 1000);
    }, 6000);
  });
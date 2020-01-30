/*####################################
    Carousel de la page d'acceuil
#####################################*/

var slideIndex = 1;
showSlides(slideIndex);

// Controle avant / arrière.
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}


/*#########################################
     Le titre de la page constructeur
#########################################*/


// type anything here
const text = 'Coucou';

// this function turns a string into an array
const createLetterArray = string => {
  return string.split('');
};

// this function creates letter layers wrapped in span tags
const createLetterLayers = array => {
  return array.map(letter => {
    let layer = '';
    //specify # of layers per letter
    for (let i = 1; i <= 2; i++) {if (window.CP.shouldStopExecution(0)) break;
      // if letter is a space
      if (letter == ' ') {
        layer += '<span class="space"></span>';
      } else {
        layer += '<span class="letter-' + i + '">' + letter + '</span>';
      }
    }window.CP.exitedLoop(0);
    return layer;
  });
};

// this function wraps each letter in a parent container
const createLetterContainers = array => {
  return array.map(item => {
    let container = '';
    container += '<div class="wrapper">' + item + '</div>';
    return container;
  });
};

// use a promise to output text layers into DOM first
const outputLayers = new Promise(function (resolve, reject) {
  document.getElementById('text').innerHTML = createLetterContainers(createLetterLayers(createLetterArray(text))).join('');
  resolve();
});

// then adjust width and height of each letter
const spans = Array.prototype.slice.call(document.getElementsByTagName('span'));
outputLayers.then(() => {
  return spans.map(span => {
    setTimeout(() => {
      span.parentElement.style.width = span.offsetWidth + 'px';
      span.parentElement.style.height = span.offsetHeight + 'px';
    }, 250);
  });
}).then(() => {
  // then slide letters into view one at a time
  let time = 250;
  return spans.map(span => {
    time += 75;
    setTimeout(() => {
      span.parentElement.style.top = '0px';
    }, time);
  });
});


/*#########################################
     Confirmation de la suppression
#########################################*/


function ConfirmMessage() {
      if (confirm("Voulez-vous vraiment Supprimer cet élément ?"))
      {
      } else {
          event.preventDefault();
          }
  }

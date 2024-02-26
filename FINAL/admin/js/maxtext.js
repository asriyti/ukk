document.addEventListener('DOMContentLoaded', function () {
    var elements = document.querySelectorAll('.judul');

    elements.forEach(function (element) {
      var originalText = element.textContent;

      if (originalText.length > 24) {
        var shortenedText = originalText.substring(0, 24) + '...';
        element.textContent = shortenedText;
      }
    });
  });
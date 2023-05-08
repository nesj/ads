const icons = document.querySelectorAll(".icons");

icons.forEach(icon => {
  const input = icon.querySelector(".file-input");

  input.addEventListener("change", function() {
    const file = this.files[0];

    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function() {
        icon.querySelector("img").setAttribute("src", reader.result);
      });

      reader.readAsDataURL(file);
    }
  });
});
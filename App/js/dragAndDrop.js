function dragAndDrop() {
    dropContainer.ondragover = dropContainer.ondragenter = function (evt) {
      evt.preventDefault();
    };
  
    let valores_ = [];
    dropContainer.ondrop = function (evt) {
      file.files = evt.dataTransfer.files;
  
      const dT = new DataTransfer();
  
      let i = 0;
      for (i = 0; i < evt.dataTransfer.files.length; i++) {
        var reader = new FileReader();
  
        // Assuming you want to read the content of the file
        reader.onload = function (event) {
          // Access the content of the file using event.target.result
          console.log(event.target.result);
        };
  
        reader.readAsText(evt.dataTransfer.files[i]);
        valores_.push(reader);
        dT.items.add(evt.dataTransfer.files[i]);
      }
  
      file.files = dT.files;
  
      evt.preventDefault();
    };
  }
  
  export { dragAndDrop };
  
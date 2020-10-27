//https://stackoverflow.com/questions/59190905/vuejs-ckeditor5-upload-images
export default class MyUploadAdapter {
  constructor(loader) {
    // The file loader instance to use during the upload.
    this.loader = loader;
  }

  // Starts the upload process.
  upload() {
    return this.loader.file
      .then(file => new Promise((resolve, reject) => {
        this._initRequest();
        this._initListeners(resolve, reject, file);
        this._sendRequest(file);
      }));
  }

  // Aborts the upload process.
  abort() {
    if (this.xhr) {
      this.xhr.abort();
    }
  }

  // Initializes the XMLHttpRequest object using the URL passed to the constructor.
  _initRequest() {
    const xhr = this.xhr = new XMLHttpRequest();

    // Note that your request may look different. It is up to you and your editor
    // integration to choose the right communication channel. This example uses
    // a POST request with JSON as a data structure but your configuration
    // could be different.
    xhr.open('POST', '/api/editor-file-upload', true);
    xhr.responseType = 'json';
  }

  // Initializes XMLHttpRequest listeners.
  _initListeners(resolve, reject, file) {
    const xhr = this.xhr;
    const loader = this.loader;
    const genericErrorText = `ไม่สามารถอัพโหลดไฟล์ ${file.name} ได้`;

    xhr.addEventListener('error', () => reject(genericErrorText));
    xhr.addEventListener('abort', () => reject());
    xhr.addEventListener('load', () => {
      const response = xhr.response;

      // This example assumes the XHR server's "response" object will come with
      // an "error" which has its own "message" that can be passed to reject()
      // in the upload promise.
      //
      // Your integration may handle upload errors in a different way so make sure
      // it is done properly. The reject() function must be called when the upload fails.
      if (!response || response.error.code !== 0) {
        return reject(response && response.error ? response.error.message : genericErrorText);
      }

      // If the upload is successful, resolve the upload promise with an object containing
      // at least the "default" URL, pointing to the image on the server.
      // This URL will be used to display the image in the content. Learn more in the
      // UploadAdapter#upload documentation.
      resolve({
        default: response.url
      });
    });

    // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
    // properties which are used e.g. to display the upload progress bar in the editor
    // user interface.
    if (xhr.upload) {
      xhr.upload.addEventListener('progress', evt => {
        if (evt.lengthComputable) {
          loader.uploadTotal = evt.total;
          loader.uploaded = evt.loaded;
        }
      });
    }
  }

  // Prepares the data and sends the request.
  _sendRequest(file) {
    /*const pica = require('pica')();
    pica.resize(file, null)
      .then(result => pica.toBlob(result, 'image/jpeg', 0.90))
      .then(blob => {
        const data = new FormData();
        data.append('upload', blob);

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send(data);
      });*/

    this.resize(file, 1000, 1000, (resizedFile) => {
      // Prepare the form data.
      const data = new FormData();
      data.append('upload', resizedFile);

      // Important note: This is the right place to implement security mechanisms
      // like authentication and CSRF protection. For instance, you can use
      // XMLHttpRequest.setRequestHeader() to set the request headers containing
      // the CSRF token generated earlier by your application.

      // Send the request.
      this.xhr.send(data);
    });
  }

  resize(file, maxWidth, maxHeight, callback) {
    const fileReader = new FileReader();
    const canvas = document.createElement('canvas');
    let context = null;
    const imageObj = new Image();
    //let blob = null;

    // check for an image then
    //trigger the file loader to get the data from the image
    if (file.type.match('image.*')) {
      fileReader.readAsDataURL(file);
    } else {
      alert('ไม่ใช่รูปภาพ');
    }

    // setup the file loader onload function
    // once the file loader has the data it passes it to the
    // image object which, once the image has loaded,
    // triggers the images onload function
    fileReader.onload = function () {
      imageObj.src = this.result;
    };

    fileReader.onabort = function () {
      alert("The upload was aborted.");
    };

    fileReader.onerror = function () {
      alert("เกิดข้อผิดพลาดในการอ่านข้อมูลไฟล์");
    };

    // set up the images onload function which clears the hidden canvas context,
    // draws the new image then gets the blob data from it
    imageObj.onload = function () {
      // Check for empty images
      if (this.width === 0 || this.height === 0) {
        alert('Image is empty');
      } else {
        if (this.width > this.height) {
          maxHeight = this.height * maxWidth / this.width;
        } else {
          maxWidth = this.width * maxHeight / this.height;
        }
        if (maxWidth > this.width) {
          maxWidth = this.width;
          maxHeight = this.height;
        }

        //create a hidden canvas object we can use to create the new resized image data
        canvas.id = "hiddenCanvas";
        canvas.width = maxWidth;
        canvas.height = maxHeight;
        canvas.style.display = 'none';
        //canvas.style.visibility = "hidden";
        document.body.appendChild(canvas);

        //get the context to use
        context = canvas.getContext('2d');

        context.clearRect(0, 0, maxWidth, maxHeight);
        context.drawImage(imageObj, 0, 0, this.width, this.height, 0, 0, maxWidth, maxHeight);

        //dataURItoBlob function available here:
        // http://stackoverflow.com/questions/12168909/blob-from-dataurl
        // add ')' at the end of this function SO dont allow to update it without a 6 character edit
        //blob = dataURItoBlob(canvas.toDataURL(imageEncoding));

        fetch(canvas.toDataURL())
          .then(res => res.blob())
          .then(blob => callback(blob));

        //pass this blob to your upload function
        //callback(blob);
      }
    };

    imageObj.onabort = function () {
      alert("Image load was aborted.");
    };

    imageObj.onerror = function () {
      alert("An error occured while loading image.");
    };
  }
}

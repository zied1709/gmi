// image produit n°1
var picture = document.getElementById("image");


// La fonction previewPicture
var previewPicture  = function (e) {

    // e.files contient un objet FileList
    const [image] = e.files

    // "picture" est un objet File
    if (image) {
        // On change l'URL de l'image
        picture.src = URL.createObjectURL(image)
    }
} 

// image produit n°2
var picture2 = document.getElementById("image2");


// La fonction previewPicture
var previewPicture2  = function (e) {

    // e.files contient un objet FileList
    const [image2] = e.files

    // "picture" est un objet File
    if (image2) {
        // On change l'URL de l'image
        picture2.src = URL.createObjectURL(image2)
    }
} 

// image produit n°3
var picture3 = document.getElementById("image3");


// La fonction previewPicture
var previewPicture3  = function (e) {

    // e.files contient un objet FileList
    const [image3] = e.files

    // "picture" est un objet File
    if (image3) {
        // On change l'URL de l'image
        picture3.src = URL.createObjectURL(image3)
    }
} 

// image produit n°4
var picture4 = document.getElementById("image4");


// La fonction previewPicture
var previewPicture4  = function (e) {

    // e.files contient un objet FileList
    const [image4] = e.files

    // "picture" est un objet File
    if (image4) {
        // On change l'URL de l'image
        picture4.src = URL.createObjectURL(image4)
    }
} 

// image user
var picture_user = document.getElementById("image_user");


// La fonction previewPicture
var previewPictureUser  = function (e) {

    // e.files contient un objet FileList
    const [image_user] = e.files

    // "picture" est un objet File
    if (image_user) {
        // On change l'URL de l'image
        picture_user.src = URL.createObjectURL(image_user)
    }
} 
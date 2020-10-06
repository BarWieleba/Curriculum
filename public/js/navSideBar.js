function openNav() {
    document.getElementById("sideNavId").style.width = "250px";
}

function closeNav() {
    document.getElementById("sideNavId").style = "0";
}
let callScroll = function scrollTo(id){
    document.getElementById(id).scrollIntoView({behavior: "smooth"});
}

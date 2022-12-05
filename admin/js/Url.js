const nav = document.querySelectorAll('.navigation-menu a');

for (let index = 0; index < nav.length; index++) {
    // console.log(nav[index].getAttribute('href'));
    // console.log(window.location.pathname);
    if(window.location.pathname == '/inscription/admin/inscription.php' && nav[index].getAttribute('href') == 'inscription.php'){
        nav[index].classList.add('active');
    } else if(window.location.pathname == '/inscription/admin/statistique.php' && nav[index].getAttribute('href') == 'statistique.php'){
        nav[index].classList.add('active');
    } else if((window.location.pathname == '/inscription/admin/index.php' || window.location.href == '/inscription/admin/') && nav[index].getAttribute('href') == 'index.php'){
        nav[index].classList.add('active');
    } 
}

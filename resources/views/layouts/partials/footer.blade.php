<!-- Footer Section Begin -->
<footer class="footer set-bg" data-setbg="{{ asset('front/img/footer-bg.jpg') }}">
    <div class="container">
        <div class="footer__contact">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__contact__title">
                        <h2 style="color: #fff; font-size: 24px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            Achat, vente et echange de voitures
                        </h2>
                        <p class="text-muted" style="font-size: 14px; margin-top: 5px;">
                            Trouvez ou échangez votre véhicule rapidement au meilleur prix.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__contact__option text-md-right">
                        <div class="option__item" style="font-size: 16px; font-weight: 700; margin-bottom: 5px;">
                            Contact: <a href="tel:0659719027" style="color: inherit; text-decoration: none;">0659719027</a> / <a href="tel:0795632144" style="color: inherit; text-decoration: none;">0795632144</a>
                        </div>
                        <div class="option__item email-text" style="font-size: 14px; color: #b7b7b7;">
                            Email: contact@mbmotors.com
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ url('/') }}" style="font-weight: 900; font-size: 30px; color: #fff; text-transform: uppercase; text-decoration: none; font-family: 'Montserrat', sans-serif; letter-spacing: 1px;">
                            <span class="brand-accent" style="color: #4B9FE1;">MB</span> Motors
                        </a>
                    </div>
                    <p style="color: #b7b7b7; font-size: 14px; line-height: 24px; margin-top: 15px;">
                        Votre plateforme de confiance pour l'achat, la vente et l'échange de véhicules d'occasion et neufs. Contactez-nous directement pour toute demande ou estimation.
                    </p>
                    <div class="footer__social-links" style="margin-top: 20px;">
                        <a href="#" class="footer-link">Facebook</a>
                        <a href="#" class="footer-link">Twitter</a>
                        <a href="#" class="footer-link">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3">
                <div class="footer__widget">
                    <h5 style="color: #fff; font-weight: 700; text-transform: uppercase; font-size: 16px; margin-bottom: 20px;">Information</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="{{ url('/') }}" class="footer-link">Accueil</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">A Propos</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Contact</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Deposer une annonce</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="footer__widget">
                    <h5 style="color: #fff; font-weight: 700; text-transform: uppercase; font-size: 16px; margin-bottom: 20px;">Vehicules</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Berline</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">SUV et 4x4</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Utilitaire</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Hatchback</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer__brand">
                    <h5 style="color: #fff; font-weight: 700; text-transform: uppercase; font-size: 16px; margin-bottom: 20px;">Marques</h5>
                    <ul style="list-style: none; padding: 0; float: left; width: 50%;">
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Toyota</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Hyundai</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Peugeot</a></li>
                    </ul>
                    <ul style="list-style: none; padding: 0; float: left; width: 50%;">
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Renault</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Volkswagen</a></li>
                        <li style="margin-bottom: 10px;"><a href="#" class="footer-link">Dacia</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright__text" style="border-top: 1px solid rgba(255, 255, 255, 0.1); margin-top: 40px; padding-top: 20px; text-align: center;">
            <p style="color: #b7b7b7; font-size: 14px;">Copyright &copy;<script>document.write(new Date().getFullYear());</script> Tous droits reserves | Hadj Aissa</p>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">Fermer</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Rechercher un vehicule ici...">
        </form>
    </div>
</div>
<!-- Search End -->

<!-- كود الـ CSS المدمج لحقن ألوان الهوية الأزرق -->
<style>
    .footer-link {
        color: #b7b7b7 !important;
        text-decoration: none !important;
        font-size: 14px !important;
        transition: color 0.3s ease;
    }
    
    .footer__social-links a {
        margin-right: 15px;
    }

    .footer-link:hover {
        color: #4B9FE1 !important; /* التحول إلى اللون الأزرق عند التمرير */
    }

    /* تغيير لون الحدود السفلية لحقل إدخال البحث عند التركيز ليصبح أزرق */
    .search-model-form input:focus {
        border-bottom: 2px solid #4B9FE1 !important;
    }
</style>
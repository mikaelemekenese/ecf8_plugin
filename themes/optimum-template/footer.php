        <footer class="footer">
            <div class="container">
                <nav class="level">
                    <div class="level-left">
                        <div class="level-item has-text-left">
                            <ul><b>Nos clubs</b><br>
                                <li>Nouméa Centre-Ville</li>
                                <li>Ducos</li>
                                <li>Dumbéa-sur-Mer</li>
                                <li>Pont des Français</li>
                            </ul>
                        </div>
                    </div>
                    <div class="level-item has-text-centered">
                        <ul>
                            <a href="<?php echo home_url('/'); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
                            </a>
                                
                            <br><br><b>Rejoignez-vous sur les réseaux sociaux</b><br><br>
                            <li style="display:inline;margin-right:10px;"><a style="color:#D4AF37;" href="<?php echo home_url('/'); ?>"><i class="fa fa-facebook fa-2x"></i></a></li>
                            <li style="display:inline;margin-right:10px;"><a style="color:#D4AF37;" href="<?php echo home_url('/'); ?>"><i class="fa fa-instagram fa-2x"></i></a></li>
                            <li style="display:inline;margin-right:10px;"><a style="color:#D4AF37;" href="<?php echo home_url('/'); ?>"><i class="fa fa-twitter fa-2x"></i></a></li>
                        </ul>
                    </div>
                    <div class="level-right has-text-right">
                        <ul><b>Nos horaires</b><br>
                            <li>Ouvert 7 jours sur 7</li>
                            <li>De 5h à 22h</li>
                            <li>(5h à 21h le dimanche)</li>
                        </ul>
                    </div>
                </nav>
            </div>  
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
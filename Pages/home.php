<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Loopi – your favorite place for playlists, artists, and trending music.">
    <meta name="keywords" content="music, playlists, artists, charts, Loopi, streaming">
    <meta name="author" content="Karol">
    <meta name="theme-color" content="#121212">
    <title>Loopi <?= htmlspecialchars($title ?? 'Сторінка', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" href="../Photo/logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="Styles/style.css">
    <link rel="stylesheet" type="text/css" href="Styles/normalize.css">
</head>
<body class="">
    <header class="">

        <nav>
            <a href="#"><img src="../Photo/logo.png" alt="Loopi" class="main_logo" width="70" height="70" style="top: 0;"></a>
            <div class="searchBox" role="search">
                <input class="searchInput" type="text" placeholder="Search">
                <button class="searchButton" aria-label="Search button">
                    <img src="../Photo/searchbar.png" alt="Search" style="height: 10px; width: 10px;">
                </button>
            </div>
            <?php if(empty($_SESSION['login'])): ?>
              <a href="Pages/login.php"><button class="icon">Log in</button></a>
            <?php endif; ?>
            <?php if(!empty($_SESSION['login'])): ?>
              <a href="?logout=1" style="right:250px; text-align:center; padding: 7px 2px 0px 2px; color: aliceblue;" class="icon">Log out</a>
              <button class="logind"><?php echo $_SESSION['login'][0]?></button>
            <?php endif; ?>
            <button class="bell">
                <img src="../Photo/bell.png" alt="Bell" style="height: 20px; width: 20px;" aria-label="Open notifications">
            </button>
        </nav>
    </header>

    <main class="main">
        <aside class="library" role="complementary" aria-label="User library">
          <p>
            <?php
              echo "Привіт, " . ($_SESSION['login'] ?? 'КОРИСТУВАЧ НЕ АВТОРИЗОВАНИЙ');
            ?>
          </p>
            <h2 class="plibrary"><strong>Your library</strong></h2>
            <button class="buttonlibrary"><b>+</b></button>
            <section class="divlibrary1">
                <h3><b>Create your first playlist</b></h3>
                <p>It's easy, we'll help you</p>
                <button>Create playlist</button>
            </section>
            <section class="divlibrary2" aria-labelledby="browse-podcasts-title">
                <h3 id="browse-podcasts-title"><b>Let's find some podcasts to follow</b></h3>
                <p>We'll keep you updated on new episodes</p>
                <button>Browse podcasts</button>
            </section>
        </aside>

        <section class="recommend" aria-label="Recommendations">
            <section class="trendsongs" aria-labelledby="trend-title">
                <h1 id="trend-title" class="precommend">Trend songs</h1>
                <div class="responsive">
                    <div class="gallery">
                        <span id="gallery0"></span>
                        <!--<img src="../Photo/BirdOfPray.jpg" alt="BirdOfPray">-->
                        <div class="desc">
                            <p><b>Bird of pray</b></p>
                            <p>Ziferblat</p>
                        </div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <span id="gallery1"></span>
                        <!--<img src="../Photo/Lighter.jpg" alt="Lighter">-->
                        <div class="desc">
                            <p><b>Lighter</b></p>
                            <p>Kyle</p>
                        </div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <span id="gallery2"></span>
                        <!--<img src="../Photo/TheCode.png" alt="TheCode">-->
                        <div class="desc">
                            <p><b>The Code</b></p>
                            <p>Nemo</p>
                        </div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <span id="gallery3"></span>
                        <!--<img src="../Photo/MySea.jfif" alt="MySea">-->
                        <div class="desc">
                            <p><b>My Sea</b></p>
                            <p>Molodi</p>
                        </div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <span id="gallery4"></span>
                        <!--<img src="../Photo/WhatTheHellJustHappend.jpg" alt="WhatTheHell">-->
                        <div class="desc">
                            <p><b>What the hell just happened?</b></p>
                            <p>Remember Monday</p>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </section>

            <section class="popularsingers" aria-labelledby="popular-artists-title">
                <h2 id="popular-artists-title" class="precommend"><b>Popular artists</b></h2>
                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/LadyGaga.webp" alt="LadyGaga">
                        <div class="desc"><p><b>Lady Gaga</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/Ziferblat.jfif" alt="Ziferblat">
                        <div class="desc"><p><b>Ziferblat</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/JeryHeil.jpg" alt="JeryHeil">
                        <div class="desc"><p><b>Jery Heil</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/Molodi.jfif" alt="Molodi">
                        <div class="desc"><p><b>Molodi</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/Ado.jpg" alt="Ado">
                        <div class="desc"><p><b>Ado</b></p></div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </section>

            <section class="featuredcharts" aria-labelledby="featured-charts-title">
                <h2 id="featured-charts-title" class="precommend"><b>Featured charts</b></h2>
                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/TopSongsGlobal.jpg" alt="TopSongsGlobal">
                        <div class="desc"><p><b>Top songs global</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/TopSongsUkraine.jpg" alt="TopSongsUkraine">
                        <div class="desc"><p><b>Top Songs Ukraine</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/Top50SongsGlobal.jpg" alt="Top50Global">
                        <div class="desc"><p><b>Top 50 songs global</b></p></div>
                    </div>
                </div>

                <div class="responsive">
                    <div class="gallery">
                        <img src="../Photo/Top50SongsUkraine.jpg" alt="Top50Ukraine">
                        <div class="desc"><p><b>Top 50 songs Ukraine</b></p></div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </section>
        </section>
    </main>

    <footer class="spotify-footer" role="contentinfo" aria-label="Footer">
        <section class="footer-grid">
            <section>
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Jobs</a></li>
                    <li><a href="#">For the Record</a></li>
                </ul>
            </section>

            <section>
                <h3>Communities</h3>
                <ul>
                    <li><a href="#">For Artists</a></li>
                    <li><a href="#">Developers</a></li>
                    <li><a href="#">Advertising</a></li>
                    <li><a href="#">Investors</a></li>
                    <li><a href="#">Vendors</a></li>
                </ul>
            </section>

            <section>
                <h3>Useful links</h3>
                <ul>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Free Mobile App</a></li>
                    <li><a href="#">Popular by Country</a></li>
                </ul>
            </section>

            <section>
                <h3>Spotify Plans</h3>
                <ul>
                    <li><a href="#">Premium Individual</a></li>
                    <li><a href="#">Premium Duo</a></li>
                    <li><a href="#">Premium Family</a></li>
                    <li><a href="#">Premium Student</a></li>
                    <li><a href="#">Spotify Free</a></li>
                </ul>
            </section>
        </section>

        <section class="bottom-links">
            <section class="legal-links" aria-label="Legal and policies">
                <span>Legal</span>
                <span>Safety & Privacy Center</span>
                <span>Privacy Policy</span>
                <span>Cookies</span>
                <span>About Ads</span>
                <span>Accessibility</span>
            </section>
            <div class="copyright">&copy; 2025 Spotify AB</div>
        </section>
    </footer>

    <script src="Scripts/script.js"></script>
</body>
</html>

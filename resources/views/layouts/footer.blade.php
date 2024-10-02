    
        <div class="site-footer">
            <div class="inner first">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="widget">
                                <h3 class="heading">About Green Travel</h3>
                                <p>Calculate to measure your commute's impact on the environment.</p>
                            </div>
                            <div class="widget">
                                <ul class="list-unstyled social">
                                    <li><a href="#"><span class="icon-twitter"></span></a></li>
                                    <li><a href="#"><span class="icon-instagram"></span></a></li>
                                    <li><a href="#"><span class="icon-facebook"></span></a></li>
                                    <li><a href="#"><span class="icon-linkedin"></span></a></li>
                                    <li><a href="#"><span class="icon-dribbble"></span></a></li>
                                    <li><a href="#"><span class="icon-pinterest"></span></a></li>
                                    <li><a href="#"><span class="icon-apple"></span></a></li>
                                    <li><a href="#"><span class="icon-google"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 pl-lg-5">
                            <div class="widget">
                                <h3 class="heading">Pages</h3>
                                <ul class="links list-unstyled">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('service.index') }}">Services</a></li>
                                    <li><a href="{{ route('about.us') }}">About</a></li>
                                    <li><a href="{{ route('contact.us') }}">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-2">
                            <div class="widget">
                                <h3 class="heading">Resources</h3>
                                <ul class="links list-unstyled">
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-lg-4">
                            <div class="widget">
                                <h3 class="heading">Contact</h3>
                                <ul class="list-unstyled quick-info links">
                                    <li class="email"><a href="#">mail@example.com</a></li>
                                    <li class="phone"><a href="#">+353 22 333 4444</a></li>
                                    <li class="address"><a href="#">Dublin City University, Collins Ave Ext, Whitehall, Dublin 9</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
    
    
            <div class="inner dark">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-8 mb-3 mb-md-0 mx-auto">
                            <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved.</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    
        <div id="overlayer"></div>
        <div class="loader">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        
        
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
        <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
        <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('js/aos.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/daterangepicker.js') }}"></script>

        <script src="js/typed.js"></script>
        <script>
            $(function() {
                var slides = $('.slides'),
                images = slides.find('img');

                images.each(function(i) {
                    $(this).attr('data-id', i + 1);
                })

                var typed = new Typed('.typed-words', {
                    strings: ["footprint."],
                    typeSpeed: 80,
                    backSpeed: 80,
                    backDelay: 3000,
                    startDelay: 1000,
                    loop: true,
                    showCursor: true,
                    preStringTyped: (arrayPos, self) => {
                        arrayPos++;
                        $('.slides img').removeClass('active');
                        $('.slides img[data-id="'+arrayPos+'"]').addClass('active');
                    }

                });
            })
        </script>

        <script src="js/custom.js"></script>
        @yield('script')
    </body>
</html>
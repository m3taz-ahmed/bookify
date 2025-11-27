
                    <div class="flex items-center justify-center mr-4">
                        <span class="mr-2 text-sm">AR</span>
                        <a href="https://bookify.test/lang/en" 
                           class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background bg-primary text-primary-foreground hover:bg-primary/90 h-10 py-2 px-4">
                            EN
                        </a>
                    </div>
                    @if(app()->getLocale() === "ar")
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.documentElement.setAttribute("dir", "rtl");
                            document.documentElement.setAttribute("lang", "ar");
                        });
                    </script>
                    @else
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.documentElement.setAttribute("dir", "ltr");
                            document.documentElement.setAttribute("lang", "en");
                        });
                    </script>
                    @endif
                
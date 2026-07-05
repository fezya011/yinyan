{{-- Если хотите использовать Alpine.js вместо чистого JS --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('headerController', () => ({
            isHidden: false,
            lastScrollTop: 0,
            scrollThreshold: 100,
            hoverTimeout: null,

            init() {
                this.handleScroll();

                window.addEventListener('scroll', () => {
                    this.handleScroll();
                }, { passive: true });

                window.addEventListener('resize', () => {
                    if (this.isHidden) {
                        this.isHidden = false;
                    }
                });
            },

            handleScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > this.lastScrollTop && scrollTop > this.scrollThreshold) {
                    this.isHidden = true;
                } else {
                    this.isHidden = false;
                }

                this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            },

            showOnHover() {
                if (this.isHidden) {
                    clearTimeout(this.hoverTimeout);
                    this.isHidden = false;

                    this.hoverTimeout = setTimeout(() => {
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        if (scrollTop > this.scrollThreshold) {
                            this.isHidden = true;
                        }
                    }, 3000);
                }
            }
        }));
    });
</script>

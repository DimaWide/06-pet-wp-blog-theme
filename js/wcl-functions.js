const ready = (callback) => {
    if (document.readyState != "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {


    /*
    * Prevent CF7 form duplication emails
    */
    let cf7_forms_submit = document.querySelectorAll('.wpcf7-form .wpcf7-submit');

    if (cf7_forms_submit) {
        cf7_forms_submit.forEach((element) => {

            element.addEventListener('click', (e) => {

                let form = element.closest('.wpcf7-form');

                if (form.classList.contains('submitting')) {
                    e.preventDefault();
                }

            });

        });
    }


    /* SCRIPTS GO HERE */






    // acf-3-blog-posts / posts
    if (document.querySelector('.sct-blog')) {
        let section = document.querySelector('.sct-blog')
        let load_more = section.querySelector('.data-load-more')

        const searchInput = document.querySelector('.wp-block-search .wp-block-search__input'); // Убедитесь, что селектор совпадает с вашим
        if (searchInput) {
            searchInput.removeAttribute('required');
        }

        // load_more
        if (load_more) {
            load_more.addEventListener("click", function (e) {
                e.preventDefault();
                if (e.target.classList.contains('data-load-more-btn')) {
                    if (e.target.getAttribute("disable") == 'disable') {
                        return false;
                    }

                    let self = e.target
                    let page = e.target.getAttribute("data-page");

                    self.classList.add('mod-active')
                    blog_page_load_posts(page);
                }
            });
        }



        // Fixed on Scroll

        function sidebar_set() {
            if (section.querySelector('.data-sidebar')) {
                if (window.matchMedia("(min-width: 991px)").matches) {
                    let sidebar = section.querySelector('.data-sidebar')
                    let content = section.querySelector('.data-content')

                    let sidebar_top = content.offsetTop - 15

                    let sidebar_bot = content.offsetTop + content.clientHeight
                    sidebar_bot = sidebar_bot - sidebar.clientHeight
                    let sidebar_bot_2 = content.clientHeight - sidebar.clientHeight

                    if (sidebar_bot_2 < 0) {
                        sidebar_bot_2 = 0
                    }

                    let scrolled = window.scrollY
                    let init = scrolled - sidebar_top

                    if (scrolled >= sidebar_top && scrolled <= sidebar_bot) {
                        sidebar.classList.add('active')
                        sidebar.classList.remove('active-2')
                        sidebar.style.top = '15px'
                    } else {
                        if (scrolled >= sidebar_top) {
                            sidebar.classList.remove('active')
                            sidebar.classList.add('active-2')
                            sidebar.style.top = sidebar_bot_2 + 'px'
                        } else {
                            sidebar.classList.remove('active')
                        }
                    }

                    window.addEventListener('scroll', function (e) {
                        sidebar_bot = content.offsetTop + content.clientHeight
                        sidebar_bot = sidebar_bot - sidebar.clientHeight
                        sidebar_bot_2 = content.clientHeight - sidebar.clientHeight

                        if (sidebar_bot_2 < 0) {
                            sidebar_bot_2 = 0
                        }

                        let scrolled = window.scrollY
                        let init = scrolled - sidebar_top
                        console.log(scrolled)
                        console.log(sidebar_bot)
                        console.log(sidebar_top)
                        if (scrolled >= sidebar_top && scrolled <= sidebar_bot) {
                            sidebar.classList.add('active')
                            sidebar.classList.remove('active-2')
                            sidebar.style.top = '15px'
                        } else {
                            if (scrolled >= sidebar_top) {
                                sidebar.classList.remove('active')
                                sidebar.classList.add('active-2')
                                sidebar.style.top = sidebar_bot_2 + 'px'
                            } else {
                                sidebar.classList.remove('active')
                                sidebar.style.top = 0
                            }
                        }
                    });
                }
            }
        }

        sidebar_set()


        // blog_page_load_posts
        function blog_page_load_posts(page_new) {
            let page = 1;
            let category = '';

            if (page_new) {
                page = parseInt(page_new) + 1;
            }

            let data_request = {
                action: 'blog_page_load_posts',
                page: page,
            }

            if (section.querySelector('.data-list')) {
                section.querySelector('.data-list').classList.add('active')
            }

            load_more.querySelector('button').setAttribute('disabled', 'disabled')
            load_more.querySelector('button').classList.add('active')

            load_more.querySelector('button').textContent = 'Loading'

            let xhr = new XMLHttpRequest();
            xhr.open('POST', wcl_obj.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.onload = function (data) {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);

                    load_more.querySelector('button').classList.remove('active')
                    load_more.querySelector('button').removeAttribute('disabled')

                    if (page_new) {
                        section.querySelector('.data-list').insertAdjacentHTML('beforeend', data.posts);
                        section.querySelector('.data-load-more').innerHTML = data.button;
                    } else {
                        section.querySelector('.data-list').innerHTML = data.posts;
                        section.querySelector('.data-load-more').innerHTML = data.button;
                    }

                    if (section.querySelector('.data-list').classList.contains('active')) {
                        section.querySelector('.data-list').classList.remove('active')
                    }

                    sidebar_set()
                };
            };

            data_request = new URLSearchParams(data_request).toString();
            xhr.send(data_request);
        }
    }



    // cmp-4-popup
    if (document.querySelector('.cmp-4-popup')) {
        let items = document.querySelectorAll('.cmp-4-popup')

        items.forEach(element => {
            element.querySelectorAll('.js-close').forEach(close => {
                close.addEventListener('click', function (e) {
                    element.classList.remove('active')
                    document.querySelector('body').classList.remove('overflow-hidden');
                    document.querySelector('html').classList.remove('overflow-hidden');
                })
            });

            element.querySelector('.cmp4-overlay').addEventListener('click', function (e) {
                element.classList.remove('active')
                document.querySelector('body').classList.remove('overflow-hidden');
                document.querySelector('html').classList.remove('overflow-hidden');
            })

            element.querySelector('.cmp4-inner-out').addEventListener('click', function (e) {
                if (!e.target.closest('.cmp4-inner')) {
                    element.classList.remove('active')
                    document.querySelector('body').classList.remove('overflow-hidden');
                    document.querySelector('html').classList.remove('overflow-hidden');
                }
            })
        });
    }



    // js-popup-open

    if (document.querySelector('.js-popup-open')) {
        let section = document.querySelector('.js-popup-open')

        // js-popup-open
        if (document.querySelector('.cmp-4-popup')) {
            let items = document.querySelectorAll('.js-popup-open')

            items.forEach(element => {
                element.addEventListener('click', function (e) {
                    e.preventDefault()

                    if (document.querySelector('.cmp-4-popup.active')) {
                        document.querySelector('.cmp-4-popup.active').classList.remove('active')

                        document.querySelectorAll('.cmp-4-popup').forEach(element => {
                            element.classList.add('mod-transit')
                        });

                        setTimeout(() => {
                            document.querySelectorAll('.cmp-4-popup.mod-transit').forEach(element => {
                                element.classList.remove('mod-transit')
                            });
                        }, 1);
                    }

                    let target_popup_id = this.getAttribute('data-target');

                    if (element.classList.contains('mod-registration-popup')) {
                        target_popup_id = 'registration-popup'
                    }

                    if (element.classList.contains('mod-login-popup')) {
                        target_popup_id = 'login-popup'
                    }

                    target_popup = document.querySelector('[data-id="' + target_popup_id + '"]');

                    if (target_popup) {
                        if (document.querySelector('.sct-header').querySelector('.data-nav').classList.contains('active')) {
                            document.querySelector('.sct-header').classList.remove('active')
                            document.querySelector('.sct-header').querySelector('.data-nav').classList.remove('active')
                        }

                        target_popup.classList.add('active')

                        document.querySelector('body').classList.add('overflow-hidden');
                        document.querySelector('html').classList.add('overflow-hidden');
                    }
                })
            });
        }
    }





    // sct-single-content

    if (document.querySelector('.sct-single-content')) {
        let section = document.querySelector('.sct-single-content')

        // Highlighted Tables Item
        if (window.matchMedia("(min-width: 991px)").matches) {
            var links = document.querySelectorAll(".data-table-contents a");
            var isUpdating = false;
            var activeLinkId = null;

            function updateActiveElement() {
                if (!isUpdating) {
                    isUpdating = true;

                    var scrollPosition = window.scrollY || window.pageYOffset;

                    // Проверьте, какая ссылка находится в зоне видимости
                    var activeLink = null;

                    Array.from(links).forEach(function (link) {
                        var targetId = link.getAttribute("href").substring(1);
                        var targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            var offset = targetElement.offsetTop - 30;
                            var height = targetElement.offsetHeight;

                            if (scrollPosition >= offset) {
                                activeLink = link;
                            }
                        }
                    });

                    // Удалите класс "active" только если активная ссылка изменилась
                    if (activeLink && activeLink.getAttribute("href") !== "#" + activeLinkId) {
                        // Удалите класс "active" со всех ссылок
                        Array.from(links).forEach(function (link) {
                            link.classList.remove("active");
                        });

                        // Добавьте класс "active" к текущей активной ссылке
                        activeLink.classList.add("active");
                        activeLinkId = activeLink.getAttribute("href").substring(1);
                    }

                    isUpdating = false;
                }
            }

            // Добавьте обработчик события прокрутки
            window.addEventListener("scroll", updateActiveElement);

            // Вызовите функцию updateActiveElement для установки начального активного элемента
            updateActiveElement();
        }


        // Fixed on Scroll
        if (section.querySelector('.data-sidebar')) {
            if (window.matchMedia("(min-width: 991px)").matches) {
                let sidebar = section.querySelector('.data-sidebar')

                let sidebar_top = sidebar.offsetTop + 1
                //console.log(sidebar_top)
                let content = section.querySelector('.data-content')
                let sidebar_bot = content.offsetTop + content.clientHeight
                sidebar_bot = sidebar_bot - sidebar.clientHeight
                let sidebar_bot_2 = content.clientHeight - sidebar.clientHeight

                if (sidebar_bot_2 < 0) {
                    sidebar_bot_2 = 0
                }

                let scrolled = window.scrollY
                let init = scrolled - sidebar_top

                if (scrolled >= sidebar_top && scrolled <= sidebar_bot) {
                    sidebar.classList.add('active')
                    sidebar.classList.remove('active-2')
                    sidebar.style.top = 0
                } else {
                    if (scrolled >= sidebar_top) {
                        sidebar.classList.remove('active')
                        sidebar.classList.add('active-2')
                        sidebar.style.top = sidebar_bot_2 + 'px'
                    } else {
                        sidebar.classList.remove('active')
                    }
                }

                window.addEventListener('scroll', function (e) {
                    sidebar_bot = content.offsetTop + content.clientHeight
                    sidebar_bot = sidebar_bot - sidebar.clientHeight
                    sidebar_bot_2 = content.clientHeight - sidebar.clientHeight

                    if (sidebar_bot_2 < 0) {
                        sidebar_bot_2 = 0
                    }

                    let scrolled = window.scrollY
                    let init = scrolled - sidebar_top

                    if (scrolled >= sidebar_top && scrolled <= sidebar_bot) {
                        sidebar.classList.add('active')
                        sidebar.classList.remove('active-2')
                        sidebar.style.top = 0
                    } else {
                        if (scrolled >= sidebar_top) {
                            sidebar.classList.remove('active')
                            sidebar.classList.add('active-2')
                            sidebar.style.top = sidebar_bot_2 + 'px'
                        } else {
                            sidebar.classList.remove('active')
                        }
                    }
                });
            }
        }



        // Anchor Link

        if (section.querySelector('.data-table-contents a')) {
            section.querySelectorAll('.data-table-contents a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 15,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        }


        // Function to copy post permalink to clipboard
        function copyToClipboard(text) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
        }

        let timeoutId;

        section.querySelector('.data-meta-item.mod-copy-link').addEventListener('click', function (e) {
            copyToClipboard(section.getAttribute('data-permalink'));

            let notify = section.querySelector('.data-meta-copy-notify')

            if (section.querySelector('.data-meta-copy-notify').classList.contains('active')) {
                section.querySelector('.data-meta-copy-notify').classList.remove('active');

                setTimeout(function () {
                    notify.classList.add('active');
                }, 150);
            } else {
                section.querySelector('.data-meta-copy-notify').classList.add('active');
            }

            // Clear the previous timeout
            if (timeoutId) {
                clearTimeout(timeoutId);
            }

            // If the notify is now active, set a new timeout to hide it after a certain duration (adjust as needed)
            if (notify.classList.contains('active')) {
                timeoutId = setTimeout(function () {
                    notify.classList.remove('active');
                }, 2000);

            }
        });


        document.addEventListener('click', function (event) {
            let notify = document.querySelector('.data-meta-copy')

            if (!notify.contains(event.target)) {
                document.querySelector('.data-meta-copy-notify').classList.remove('active');
            }
        });
    }


    // acf-3-blog-posts / posts
    if (document.querySelector('.acf-3-blog-posts')) {
        let section = document.querySelector('.acf-3-blog-posts')
        let load_more = section.querySelector('.data-load-more')
        let cats = section.querySelectorAll('.data-cats a')
        let language = document.querySelector('html').getAttribute('lang')


        // load_more
        if (load_more) {
            load_more.addEventListener("click", function (e) {
                e.preventDefault();
                if (e.target.classList.contains('data-load-more-btn')) {
                    if (e.target.getAttribute("disable") == 'disable') {
                        return false;
                    }

                    let self = e.target
                    let page = e.target.getAttribute("data-page");

                    self.classList.add('mod-active')
                    categories_page_load_post(page);
                }
            });
        }


        // cats
        if (cats) {
            if (window.matchMedia("(min-width: 991px)").matches) {
                cats.forEach(element => {
                    let categoryWidth = element.getBoundingClientRect().width;

                    element.style.width = categoryWidth + 'px';
                });
            }

            cats.forEach(element => {
                element.addEventListener("click", function (e) {
                    e.preventDefault();
                    let self = this;

                    if (this.classList.contains('active')) {
                        if (section.querySelector('.data-load-more-btn').getAttribute("data-page") != '1') {
                            categories_page_load_post();
                            return;
                        }

                        return;
                    }

                    section.querySelectorAll('.data-cats a.active').forEach(element_2 => {
                        if (element_2 != this) {
                            element_2.classList.remove('active');
                        }
                    });

                    if (self.classList.contains('active')) {
                        self.classList.remove('active');
                    } else {
                        self.classList.add('active');
                    }

                    categories_page_load_post();
                });
            });
        }

        // pagination

        let pagination = section.querySelector('.data-pagination')

        if (pagination) {
            pagination.addEventListener("click", function (e) {
                let self = e.target.closest('a')
                if (self) {
                    e.preventDefault();

                    if (e.target.classList.contains('mod-current')) {
                        return false;
                    }

                    let page = self.getAttribute("data-page");
                    categories_page_load_post(page);

                    const element = section
                    if (element) {
                        const elementPosition = element.getBoundingClientRect().top + window.pageYOffset - 50;

                        window.scrollTo({
                            top: elementPosition,
                            behavior: "smooth"
                        });
                    }
                }
            });
        }


        // buildURL
        function buildURL() {
            var activeCategories = []; // Массив для хранения активных категорий

            // Получение всех элементов с классом data-cats-item 
            var categoryItems = document.querySelectorAll('.data-cats-item a.active');

            // Перебор элементов для определения активных категорий
            categoryItems.forEach(function (item) {
                if (item.classList.contains('active')) {
                    var categorySlug = item.getAttribute('data-id'); // Получение слага категории
                    activeCategories.push(categorySlug); // Добавление слага в массив активных категорий
                }
            });

            var currentPage = document.querySelector('.data-pagination .mod-current'); // Найдем текущую страницу
            var page = currentPage ? currentPage.getAttribute('data-page') : 1; // Номер текущей страницы

            // Формирование URL с активными категориями и номером страницы
            var url = wcl_obj.site_url + 'categories' + '/';

            if (activeCategories[0] != 'all') {
                if (activeCategories.length == 1) {
                    url = wcl_obj.site_url + 'category/' + activeCategories + '/';
                } else if (activeCategories.length > 1) {
                    url += activeCategories.join(',') + '/';
                }
            }

            if (page !== '1' && document.querySelector('.data-pagination .mod-current')) {
                url += 'page/' + page + '/';
            }

            window.history.pushState(wcl_obj.site_url, document.title, url);
        }


        // categories_page_load_post
        function categories_page_load_post(page_new) {
            let page = 1;
            let category = '';

            if (section.querySelector('.data-cats a.active')) {
                category = section.querySelector('.data-cats a.active').getAttribute('data-slug')
            }

            if (page_new) {
                page = page_new;
            }

            let data_req = {
                action: 'categories_page_load_post',
                page: parseInt(page),
                category: category,
            }
            
            if (section.querySelector('.data-list')) {
                section.querySelector('.data-list').classList.add('active')
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', wcl_obj.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.onload = function (data) {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);

                    section.querySelector('.data-list').innerHTML = data.posts;
                    section.querySelector('.data-pagination-inner').innerHTML = data.pagination;

                    if (data.count_pages && data.count_pages > 1) {
                        section.querySelector('.data-pagination').classList.add('active')
                    } else {
                        section.querySelector('.data-pagination').classList.remove('active')
                    }

                    if (section.querySelector('.data-list').classList.contains('active')) {
                        section.querySelector('.data-list').classList.remove('active')
                    }

                    buildURL();
                };
            };
            data_req = new URLSearchParams(data_req).toString();
            xhr.send(data_req);
        }
    }





    // sct-header
    if (document.querySelector('.sct-header')) {
        let section = document.querySelector('.sct-header')

        window.addEventListener('scroll', function () {
            if (window.scrollY > 0) {
                section.classList.add('mod-scroll');
            } else {
                section.classList.remove('mod-scroll');
            }
        });

        section.querySelectorAll('.data-menu  li.menu-item-has-children > a').forEach(element => {
            element.addEventListener('click', function (e) {
                e.preventDefault()

                if (element) {
                    element.addEventListener('click', function (e) {
                        if (element.getAttribute('href') == '#') {
                            e.preventDefault()
                        }
                    })
                }
            })
        });

        // btn-menu
        section.querySelectorAll('.data-btn-menu').forEach(element => {
            element.addEventListener('click', function (e) {
                if (section.querySelector('.data-nav').classList.contains('active')) {
                    this.classList.remove('active')
                    section.querySelector('.data-nav').classList.remove('active')
                    section.classList.remove('active-nav')
                    document.querySelector('body, html').classList.remove('overflow-hidden')
                } else {
                    this.classList.add('active')
                    section.querySelector('.data-nav').classList.add('active')
                    section.classList.add('active-nav')
                    document.querySelector('body, html').classList.add('overflow-hidden')
                }
            })
        });


        // data-menu
        if (window.matchMedia("(max-width: 1300px)").matches) {
            section.querySelectorAll('.data-menu > li.menu-item-has-children > a').forEach(element => {
                element.addEventListener('click', function (e) {
                    e.preventDefault()

                    section.querySelectorAll('.data-menu li.active').forEach(element2 => {
                        if (this.parentElement != element2) {
                            element2.classList.remove('active')
                        }
                    });

                    if (this.parentElement.classList.contains('active')) {
                        this.parentElement.classList.remove('active')
                    } else {
                        this.parentElement.classList.add('active')
                    }
                })
            });


        }
    }






    // acf-2-category
    if (document.querySelector('.acf-2-category')) {
        let sections = document.querySelectorAll('.acf-2-category')

        sections.forEach(section => {
            let swiper = new Swiper(section.querySelector('.data-slider'), {
                slidesPerView: 3,
                loop: true,
                speed: 200,
                spaceBetween: 20,
                breakpoints: {
                    0: {
                        slidesPerView: 'auto',
                        spaceBetween: 16,
                    },
                    576: {
                        spaceBetween: 20,
                        slidesPerView: 2,
                    },
                    991: {
                        spaceBetween: 20,
                        slidesPerView: 3,
                    },
                    1199: {
                        spaceBetween: 20,
                        slidesPerView: 3,
                    },
                }
            });

        })
    }










});
import Vue from 'vue';
import Router from 'vue-router';
import store from './store';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    base: 'admin',
    routes: [
        {
            path: '/login',
            component: require('./views/Login'),
            meta: {
                requireGuest: true
            }
        },
        {
            path: '/feedback-issue/:token',
            component: require('./views/FeedbackIssue')
        },
        {
            path: '/',
            component: require('./views/Dashboard'),
            meta: {
                requireAuth: true
            },
            children: [
                {
                    path: '/',
                    component: require('./views/Home')
                },
                {
                    path: '/users',
                    component: require('./views/Users'),
                    name: 'users',
                    meta: {
                        requirePermissions: ['view user']
                    }
                },
                {
                    path: '/users/:id',
                    component: require('./views/EditUser'),
                    name: 'edit-user',
                    meta: {
                        requirePermissions: ['manage user']
                    }
                },
                {
                    path: '/products',
                    component: require('./views/Products'),
                    name: 'products',
                    meta: {
                        requirePermissions: ['view product']
                    }
                },
                {
                    path: '/products/add',
                    component: require('./views/AddProduct'),
                    name: 'add-product',
                    meta: {
                        requirePermissions: ['manage product']
                    }
                },
                {
                    path: '/products/:id',
                    component: require('./views/EditProduct'),
                    name: 'edit-product',
                    meta: {
                        requirePermissions: ['manage product']
                    }
                },
                {
                    path: '/news',
                    component: require('./views/News'),
                    name: 'news',
                    meta: {
                        requirePermissions: ['view post']
                    }
                },
                {
                    path: '/categories',
                    component: require('./views/Categories'),
                    name: 'categories',
                    meta: {
                        requirePermissions: ['view post']
                    }
                },
                {
                    path: '/categories/add',
                    component: require('./views/AddCategory'),
                    name: 'add-category',
                    meta: {
                        requirePermissions: ['manage post']
                    }
                },               
                {
                    path: '/news/add-post',
                    component: require('./views/AddPost'),
                    name: 'add-post',
                    meta: {
                        requirePermissions: ['manage post']
                    }
                },
                {
                    path: '/news/:id',
                    component: require('./views/EditPost'),
                    name: 'edit-post',
                    meta: {
                        requirePermissions: ['manage post']
                    }
                },
                {
                    path: '/admins',
                    component: require('./views/Admins'),
                    name: 'admins',
                    meta: {
                        requirePermissions: ['view admin']
                    }
                },
                {
                    path: '/admins/add',
                    component: require('./views/AddAdmin'),
                    name: 'add-admin',
                    meta: {
                        requirePermissions: ['manage admin']
                    }
                },
                {
                    path: '/admins/roles',
                    component: require('./views/Roles'),
                    name: 'roles',
                    meta: {
                        requirePermissions: ['manage admin']
                    }
                },
                {
                    path: '/admins/roles/add',
                    component: require('./views/AddRole'),
                    name: 'add-role',
                    meta: {
                        requirePermissions: ['manage admin']
                    }
                },
                {
                    path: '/admins/roles/:id',
                    component: require('./views/EditRole'),
                    name: 'edit-role',
                    meta: {
                        requirePermissions: ['manage admin']
                    }
                },
                {
                    path: '/admins/:id',
                    component: require('./views/EditAdmin'),
                    name: 'edit-admin',
                    meta: {
                        requirePermissions: ['manage admin']
                    }
                },
                {
                    path: '/settings',
                    component: require('./views/NewSetting'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/subscribers',
                    component: require('./views/Subscribers'),
                    meta: {
                        requirePermissions: ['view subscriber']
                    }
                },
                {
                    path: '/profile/change-password',
                    name: 'change-password',
                    component: require('./views/ChangePassword')
                },
                {
                    path: '/logs',
                    name: 'logs',
                    component: require('./views/Logs'),
                    meta: {
                        requirePermissions: ['view log']
                    }
                },
                {
                    path: '/banner-setting',
                    name: 'banner-setting',
                    component: require('./views/BannerSetting'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/brands',
                    name: 'brands',
                    component: require('./views/Brands'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/emails',
                    name: 'emails',
                    component: require('./views/Emails'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/day_options',
                    name: 'options',
                    component: require('./views/DayOption'),
                    meta: {
                        requirePermissions: ['manage package']
                    }
                },
                {
                    path: '/services',
                    name: 'services',
                    component: require('./views/Services'),
                    meta: {
                        requirePermissions: ['manage package']
                    }
                },
                {
                    path: '/services/add',
                    name: 'services_add',
                    component: require('./views/ServiceAdd'),
                    meta: {
                        requirePermissions: ['manage package']
                    }
                },
                {
                    path: '/services/edit/:id',
                    name: 'services_edit',
                    component: require('./views/ServiceAdd'),
                    meta: {
                        requirePermissions: ['manage package']
                    }
                },
                {
                    path: '/bills',
                    name: 'bills',
                    component: require('./views/Bills'),
                    meta: {
                        requirePermissions: ['manage bill']
                    }
                },
                {
                    path: '/campaign',
                    name: 'campaign',
                    component: require('./views/Campaign'),
                    meta: {
                        requirePermissions: ['manage campaign']
                    }
                },
                {
                    path: '/campaign/add',
                    name: 'campaign_add',
                    component: require('./views/CampaignAdd'),
                    meta: {
                        requirePermissions: ['manage campaign']
                    }
                },
                {
                    path: '/campaign/detail/:id',
                    name: 'campaign_detail',
                    component: require('./views/CampaignDetail'),
                    meta: {
                        requirePermissions: ['manage campaign']
                    }
                },

                {
                    path: '/class_category',
                    name: 'class_category',
                    component: require('./views/ClassCategory'),
                    meta: {
                        requirePermissions: ['manage class category']
                    }
                },
                {
                    path: '/class_category/add',
                    name: 'class_category_add',
                    component: require('./views/ClassCategoryAdd'),
                    meta: {
                        requirePermissions: ['manage class category']
                    }
                },
                {
                    path: '/class_category/edit/:id',
                    name: 'class_category_edit',
                    component: require('./views/ClassCategoryAdd'),
                    meta: {
                        requirePermissions: ['manage class category']
                    }
                },
            
                // Product category
                {
                    path: '/product/category',
                    name: 'product_category',
                    component: require('./views/ProductCategory'),
                    meta: {
                        requirePermissions: ['manage product']
                    }
                },
                {
                    path: '/product/category/add',
                    name: 'product_category_add',
                    component: require('./views/ProductCategoryAdd'),
                    meta: {
                        requirePermissions: ['manage product']
                    }
                },
                {
                    path: '/product/category/edit/:id',
                    name: 'product_category_edit',
                    component: require('./views/ProductCategoryAdd'),
                    meta: {
                        requirePermissions: ['manage product']
                    }
                },
                {
                    path: '/setting/seo-setting',
                    name: 'setting_seo_setting',
                    component: require('./views/SeoSetting'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },                
                {
                    path: '/setting/seolink',
                    name: 'setting_seolink',
                    component: require('./views/SeoLink'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/setting/robot',
                    name: 'setting_robot',
                    component: require('./views/Robot'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },
                {
                    path: '/setting/category',
                    name: 'setting_category',
                    component: require('./views/Category'),
                    meta: {
                        requirePermissions: ['manage setting']
                    }
                },                
            ]
        },
        {
            path: '*',
            component: require('./views/PageNotFound')
        }
    ]
});

router.beforeEach((to, from, next) => {
    const requireAuth = to.matched.some(route => route.meta.requireAuth);
    const requireGuest = to.matched.some(route => route.meta.requireGuest);
    const requirePermissions = to.meta.requirePermissions;
    const isLoggedIn = store.getters.isLoggedIn;
    const user = store.state.auth.user;

    if (requireAuth && !isLoggedIn) {
        next('/login');
    } else if (requireGuest && isLoggedIn) {
        next('/');
    } else if (requirePermissions && user.permissions) {
        var hasPermission = false;
        for (var i = 0; i < requirePermissions.length; i++) {
            if (user.permissions.includes(requirePermissions[i])) {
                hasPermission = true;
            }
        }

        if (!hasPermission) {
            next('/');
            store.dispatch('alertError', 'You do not have permission to do that!');
        } else {
            next();
        }
    } else {
        next();
    }
});

router.afterEach((to, from) => {
    store.commit('updateRouteInto', {
        path: to.path,
        name: to.name
    });
});

export default router;

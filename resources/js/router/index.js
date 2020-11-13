import VueRouter from 'vue-router'

const index = [
    {
        path: '/',
        component: () => import('../pages/Home'),
    },
    {
        path: '*',
        // component: () => import('../pages/PageNotFound'),
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: index,
    linkActiveClass: 'active',
    scrollBehavior() {
        window.scrollTo(0, 0)
    }
})

export default router

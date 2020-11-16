import VueRouter from 'vue-router'

const routes = [
    {
        path: '/',
        component: () => import('../pages/Home'),
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

export default router

import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

//admin routes
import home from './components/pages/Home'
import tags from './admin/pages/Tags'
import category from './admin/pages/Category'
import admins from './admin/pages/Admins'
import login from './admin/pages/Login'
import role from './admin/pages/Role'
import permission from './admin/pages/Permission'
import blog from './admin/pages/Blog'
import notFound from './admin/pages/NotFound'


//Frontend routes
import frontHome from './frontend/pages/Home'
import blogDetail from './frontend/pages/BlogDetail'
import blogs from './frontend/pages/Blogs'
import about from './frontend/pages/About'
import contact from './frontend/pages/Contact'

const routes = [
    //admin project routes start
    {
        path: '/admin',
        component: home,
        name: '/admin'
    },
    {
        path: '/admin/tags',
        component: tags,
        name: '/admin/tags'
    },
    {
        path: '/admin/category',
        component: category,
        name: '/admin/category'
    },
    {
        path: '/admin/admins',
        component: admins,
        name: '/admin/admins'
    },
    {
        path: '/admin/login',
        component: login,
        name: '/admin/login'
    },
    {
        path: '/admin/role',
        component: role,
        name: '/admin/role'
    },
    {
        path: '/admin/permission',
        component: permission,
        name: '/admin/permission'
    },
    {
        path: '/admin/blog',
        component: blog,
        name: '/admin/blog'
    },
    {
        path: '*',
        component: notFound,
        name: 'notFound'
    },
    //admin project routes end

    //frontend project routes start
    {
        path: '/',
        component: frontHome,
        name: 'frontHome'
    },
    {
        path: '/blogs',
        component: blogs,
        name: 'blogs'
    },
    {
        path: '/blog_detail/:id',
        component: blogDetail,
        name: 'blogDetail'
    },
    {
        path: '/about',
        component: about,
        name: 'about'
    },
    {
        path: '/contact',
        component: contact,
        name: 'contact'
    },

]
export default new Router({
    mode:'history',
    routes    
})
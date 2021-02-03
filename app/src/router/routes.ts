import { RouteConfig } from 'vue-router'

const routes: RouteConfig[] = [
	{
		name: 'login',
		path: '/login',
		component: () => import('pages/login.page.vue')
	},
	{
		path: '/',
		component: () => import('layouts/MainLayout.vue'),
		children: [
			{ name: 'home', path: '', component: () => import('pages/Index.vue') },
			{
				name: 'userType',
				path: 'userType',
				component: () => import('pages/userType.page.vue'),
			},
			{
				name: 'user',
				path: 'user',
				component: () => import('pages/user.page.vue'),
			},
		]
	},
	{
		path: '*',
		component: () => import('pages/Error404.vue')
	}
]

export default routes

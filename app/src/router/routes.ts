import { RouteConfig } from 'vue-router'

const routes: RouteConfig[] = [
	{
		name: 'login',
		path: '/login',
		component: () => import('pages/login/login.page.vue')
	},
	{
		path: '/',
		component: () => import('layouts/MainLayout.vue'),
		children: [
			{ name: 'home', path: '', component: () => import('pages/Index.vue') },
			{
				name: 'userType',
				path: 'userType',
				component: () => import('pages/userType/userType.page.vue'),
			},
		]
	},
	{
		path: '*',
		component: () => import('pages/Error404.vue')
	}
]

export default routes

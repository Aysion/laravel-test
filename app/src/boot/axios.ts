import axios, { AxiosInstance } from 'axios'
import { boot } from 'quasar/wrappers'
import { Notify } from 'quasar'

declare module 'vue/types/vue' {
	interface Vue {
		$axios: AxiosInstance;
	}
}

axios.interceptors.response.use(function (response) {
	let { data } = response

	data.errors.forEach((error: string) => {
		Notify.create({
			type: 'negative',
			message: error,
			actions: [{ icon: 'close', color: 'white' }]
		})
	})

	return response;
}, function (error) {
	let { response: { data } } = error

	if (data.errors) {
		data.errors.forEach((error: string) => {
			Notify.create({
				type: 'negative',
				message: error,
				actions: [{ icon: 'close', color: 'white' }]
			})
		})
	}

	return Promise.reject(error);
});

export default boot(({ Vue }) => {
	// eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
	Vue.prototype.$axios = axios
})

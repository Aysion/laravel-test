import axios, { AxiosInstance, AxiosResponse, AxiosError } from 'axios'
import { boot } from 'quasar/wrappers'
import { Notify } from 'quasar'

declare module 'vue/types/vue' {
	interface Vue {
		$axios: AxiosInstance;
	}
}

const axiosInstance = axios.create({
	baseURL: 'http://127.0.0.1:8000/api'
})

axiosInstance.interceptors.response.use(function (response: AxiosResponse) {
	const { data }: { data: { errors: Array<string> } } = response

	if (data.errors) {
		data.errors.forEach((error: string) => {
			Notify.create({
				type: 'negative',
				message: error,
				actions: [{ icon: 'close', color: 'white' }]
			})
		})
	}

	return response;
}, function (error: AxiosError) {
	const { response } = error

	if (response) {
		const { data }: { data: { errors: Array<string> } } = response

		if (data && data.errors) {
			data.errors.forEach((error: string) => {
				Notify.create({
					type: 'negative',
					message: error,
					actions: [{ icon: 'close', color: 'white' }]
				})
			})
		}
	}

	return Promise.reject(error);
});

export default boot(({ Vue }) => {
	// eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
	Vue.prototype.$axios = axiosInstance
})

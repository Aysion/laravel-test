<template>
	<q-layout>
		<q-page-container>
			<q-page class="q-pa-xl">
				<div class="row justify-center">
					<q-card class="col-12 col-sm-6 col-md-4">
						<q-card-section class="bg-info">
							Login
						</q-card-section>

						<q-form ref="formLogin" @submit="onSubmit()">
							<q-card-section>
								<div class="q-pa-md">
									<div class="q-gutter-md">
										<q-input type="email" v-model="login.email" label="E-mail*" required />
										<q-input type="password" v-model="login.password" label="Senha*" required />
										<q-toggle v-model="keepConnected" label="Manter conectado" />
									</div>
								</div>
							</q-card-section>

							<q-card-actions vertical>
								<q-btn type="submit" color="primary">Logar</q-btn>
							</q-card-actions>
						</q-form>
					</q-card>
				</div>
			</q-page>
		</q-page-container>
	</q-layout>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import { AxiosResponse } from 'axios';

export default defineComponent({
	data() {
		return {
			keepConnected: false,
			login: {
				email: null,
				password: null,
			}
		}
	},
	methods: {
		onSubmit() {
			return this.$axios({
				method: 'post',
				url: 'auth',
				data: this.login,
			}).then((resp: AxiosResponse) => {
				this.$q[this.keepConnected ? 'localStorage' : 'sessionStorage'].set('gpToken', resp.data)

				this.$router.push({ name: 'home' })

				return resp
			}).catch(console.warn)
		}
	},
	mounted() {
		console.log('PageLogin')
	}
})
</script>

<style>
</style>

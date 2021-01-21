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
import { AxiosResponse } from 'axios';

export default {
	data() {
		return {
			login: {
				email: null,
				password: null,
			}
		}
	},
	methods: {
		onSubmit(): Promise<any> {
			return this.$axios({
				method: 'post',
				url: 'http://127.0.0.1:8000/api/auth',
				data: this.login,
			}).then((resp: AxiosResponse) => {
				this.$q.sessionStorage.set('gpToken', resp.data)

				this.$router.push({ name: 'home' })
			}).catch(console.warn)
		}
	},
	mounted() {
		console.log('PageLogin')
	}
};
</script>

<style>
</style>

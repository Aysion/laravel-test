<template>
	<q-layout>
		<q-page-container>
			<q-page class="q-pa-xl">
				<div class="row justify-center">
					<q-card class="col-12 col-sm-6 col-md-4">
						<q-card-section class="bg-info">
							Login
						</q-card-section>

						<q-card-section>
							<div class="q-pa-md">
								<div class="q-gutter-md">
									<q-form ref="formLogin">
										<q-input type="email" v-model="login.email" label="E-mail" />
										<q-input type="password" v-model="login.password" label="Senha" />
									</q-form>
								</div>
							</div>
						</q-card-section>

						<q-card-actions vertical>
							<q-btn color="primary" @click="onSubmit()">Logar</q-btn>
						</q-card-actions>
					</q-card>
				</div>
			</q-page>
		</q-page-container>
	</q-layout>
</template>

<script lang="ts">
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
			}).then(resp => {
				this.$q.sessionStorage.set('gpToken', resp.data)
			}).catch(console.warn)
		}
	},
	mounted() {

	}
};
</script>

<style>
</style>

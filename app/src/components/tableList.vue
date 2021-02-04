<template>
	<div class="q-pa-sm q-gutter-sm">
		<q-table
			row-key="id"
			separator="cell"
			:data="dataList"
			:columns="columns"
		>
			<template v-slot:top>
				<div class="col-10 q-table__title">{{ title }}</div>

				<q-space />

				<q-btn size="12px" dense round icon="add" color="positive" @click="dialogForm()">
					<q-tooltip content-class="bg-green-8" content-style="font-size: .9em" anchor="top middle" self="bottom middle" :offset="[0, 5]">
						Novo
					</q-tooltip>
				</q-btn>
			</template>

			<template v-slot:body="scope">
				<q-tr :props="scope">
					<q-td v-for="(col, key) in scope.colsMap" :key="key" :props="scope">
						<span v-if="col.name !== '_btn_'">{{ getField(scope.row, col.field)  }}</span>
						<span v-else class="q-gutter-md">
							<q-btn v-if="!scope.row.deleted_at" size="12px" dense round icon="delete" color="negative" @click="onDelete(scope)">
								<q-tooltip content-class="bg-red-8" content-style="font-size: .9em" anchor="top middle" self="bottom middle" :offset="[0, 5]">
									Deletar
								</q-tooltip>
							</q-btn>

							<q-btn v-else size="12px" dense round icon="restore_from_trash" color="secondary" @click="onRestore(scope)">
								<q-tooltip content-class="bg-teal-8" content-style="font-size: .9em" anchor="top middle" self="bottom middle" :offset="[0, 5]">
									Restaurar
								</q-tooltip>
							</q-btn>

							<q-btn v-if="!scope.row.deleted_at" size="12px" dense round icon="edit" color="primary" @click="dialogForm(scope)">
								<q-tooltip content-class="bg-blue-9" content-style="font-size: .9em" anchor="top middle" self="bottom middle" :offset="[0, 5]">
									Editar
								</q-tooltip>
							</q-btn>
						</span>
					</q-td>
				</q-tr>
			</template>
		</q-table>

		<q-dialog v-model="showDialogForm" transition-show="rotate" transition-hide="rotate" persistent>
			<q-card style="width: 700px; max-width: 80vw;">
				<q-card-section>
					<div class="text-h6">{{ title }}</div>
				</q-card-section>

				<q-form @submit="onSubmit()" ref="formSlot">
					<q-card-section class="q-pt-none scroll q-gutter-sm" style="max-height: 50vh">
						<slot name="form" :formData="formData"/>
					</q-card-section>

					<q-card-actions align="right">
						<q-btn type="submit" flat label="Salvar" color="primary" v-close-popup />
						<q-btn label="Cancelar" color="negative" v-close-popup />
					</q-card-actions>
				</q-form>
			</q-card>
		</q-dialog>

		<q-dialog v-model="dataDialogConfirm.show" persistent>
			<q-card>
				<q-card-section class="row items-center">
					<q-avatar icon="warning_amber" color="warning" text-color="white" />
					<span class="q-ml-sm" v-html="dataDialogConfirm.body"></span>
				</q-card-section>

				<q-card-actions align="right">
					<q-btn flat label="Confirmar" color="primary" v-close-popup @click="dataDialogConfirm.onConfirm"/>
					<q-btn label="Cancelar" color="negative" v-close-popup />
				</q-card-actions>
			</q-card>
		</q-dialog>
	</div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api"
import { AxiosResponse } from "axios"

export default defineComponent({
	name: 'tableList',
	props: {
		columns: {
			type: Array,
			required: true,
		},
		domain: {
			type: String,
			required: true,
		},
		title: {
			type: String,
			required: true,
		},
	},
	data() {
		return {
			showDialogForm: false,
			dataDialogConfirm: {
				show: false,
				body: '',
			},
			formData: {},
			scopeTable: null,
			dataList: [],
		}
	},
	methods: {
		dialogForm(scopeTable = null) {
			this.showDialogForm = true

			if (scopeTable) {
				this.scopeTable = scopeTable
				this.formData = JSON.parse(JSON.stringify(scopeTable.row))
			} else {
				this.scopeTable = null
				this.formData = {}
			}
		},
		getDataList() {
			this.$axios({
				method: 'get',
				url: this.domain,
				headers: {
					gpModelParams: JSON.stringify({
						withTrashed: 1,
					}),
				},
			}).then((resp: AxiosResponse) => {
				this.dataList = resp.data
			}).catch(console.warn)
		},
		onSubmit() {
			this.$axios({
				method: this.formData.id ? 'put' : 'post',
				url: `${this.domain}/${(this.formData.id || '')}`,
				data: this.formData,
			}).then((resp: AxiosResponse) => {
				this.$set(this.dataList, (this.scopeTable ? this.scopeTable.rowIndex : this.dataList.length), resp.data)

				this.$q.notify({
					type: 'positive',
					message: 'Salvo com sucesso',
					actions: [{ icon: 'close', color: 'white' }],
				})
			}).catch(console.warn)
		},
		onDelete(scopeTable) {
			this.dialogConfirm({
				body: `Deseja Deletar esse registro? <br> ID: ${scopeTable.row.id}`,
				onConfirm: () => {
					this.$axios({
						method: 'delete',
						url: `${this.domain}/${scopeTable.row.id}`,
					}).then((resp: AxiosResponse) => {
						if (resp.data) {
							this.$set(this.dataList, scopeTable.rowIndex, resp.data)
						} else {
							this.$delete(this.dataList, scopeTable.rowIndex)
						}

						this.$q.notify({
							type: 'positive',
							message: 'Deletado com sucesso',
							actions: [{ icon: 'close', color: 'white' }],
						})
					}).catch(console.warn)
				}
			})
		},
		onRestore(scopeTable) {
			this.dialogConfirm({
				body: `Deseja Restaurar esse registro? <br> ID: ${scopeTable.row.id}`,
				onConfirm: () => {
					this.$axios({
						method: 'patch',
						url: `${this.domain}/${scopeTable.row.id}/restore`,
					}).then((resp: AxiosResponse) => {
						this.$set(this.dataList, scopeTable.rowIndex, resp.data)

						this.$q.notify({
							type: 'positive',
							message: 'Restaurado com sucesso',
							actions: [{ icon: 'close', color: 'white' }],
						})
					}).catch(console.warn)
				}
			})
		},
		dialogConfirm(dataDialogConfirm) {
			Object.assign(this.dataDialogConfirm, dataDialogConfirm, { show: true })
		},
		getField(data, field: string) {
			const fieldPath = field.split('.')
			let dataCurrent = data

			for (let i = 0; i < fieldPath.length; i++) {
				const fieldCurrent = fieldPath[i]

				if (dataCurrent.hasOwnProperty(fieldCurrent)) {
					dataCurrent = dataCurrent[fieldCurrent]
				} else {
					break
				}
			}

			return dataCurrent
		},
	},
	mounted() {
		this.getDataList()
	}
})
</script>

<style>

</style>

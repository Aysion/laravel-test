<template>
	<div class="q-pa-sm q-gutter-sm">
		<q-table
			row-key="id"
			separator="cell"
			:title="title"
			:data="dataList"
			:columns="columns"
		>
			<template v-slot:body="scope" user="">
				<q-tr :props="scope">
					<q-td v-for="(col, key) in scope.colsMap" :key="key" :props="scope">
						<span v-if="col.name !== '_btn_'">{{ scope.row[col.field] }}</span>
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
			<q-card>
				<q-card-section>
					<div class="text-h6">{{ title }}</div>
				</q-card-section>

				<q-form @submit="onSubmit()" ref="formSlot">
					<q-card-section class="q-pt-none scroll" style="max-height: 50vh">
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
		dialogForm(scopeTable) {
			this.showDialogForm = true
			this.scopeTable = scopeTable
			this.formData = JSON.parse(JSON.stringify(scopeTable.row))
		},
		getDataList() {
			return this.$axios({
				method: 'get',
				url: this.domain,
				headers: {
					'gpModelParams': JSON.stringify({
						withTrashed: 1,
					}),
				},
			}).then((resp: AxiosResponse) => {
				this.dataList = resp.data
			})
		},
		onSubmit() {
			return this.$axios({
				method: this.formData.id ? 'put' : 'post',
				url: `${this.domain}/${(this.formData.id || '')}`,
				data: this.formData,
			}).then((resp: AxiosResponse) => {
				this.$set(this.dataList, this.scopeTable.pageIndex, resp.data)
			})
		},
		onDelete(scopeTable) {
			return this.dialogConfirm({
				body: `Deseja Deletar esse registro? <br> ID: ${scopeTable.row.id}`,
				onConfirm: async () => {
					await this.processDelete(scopeTable.row.id)

					this.$delete(this.dataList, scopeTable.pageIndex)
				}
			})
		},
		onRestore(scopeTable) {
			return this.dialogConfirm({
				body: `Deseja Restaurar esse registro? <br> ID: ${scopeTable.row.id}`,
				onConfirm: async () => {
					const data = await this.processRestore(scopeTable.row.id)

					this.$set(this.dataList, scopeTable.pageIndex, data)
				}
			})
		},
		processDelete(id) {
			return this.$axios({
				method: 'delete',
				url: `${this.domain}/${id}`,
			}).then((resp: AxiosResponse) => {
				return resp.data
			})
		},
		processRestore(id) {
			return this.$axios({
				method: 'put',
				url: `${this.domain}/restore/${id}`,
			}).then((resp: AxiosResponse) => {
				return resp.data
			})
		},
		async dialogConfirm(dataDialogConfirm) {
			Object.assign(this.dataDialogConfirm, dataDialogConfirm, { show: true })

			return true
		}
	},
	mounted() {
		this.getDataList()
	}
})
</script>

<style>

</style>

<template>
	<div class="q-pa-sm q-gutter-sm">
		<q-table
			row-key="id"
			separator="cell"
			no-data-label="Nenhum registro encontrado"
			no-results-label="O filtro não encontrou nenhum resultado"
			class="my-sticky-virtscroll-table"
			virtual-scroll
			:data="tableList.data"
			:columns="columns"
			:loading="tableList.loading"
			:rows-per-page-options="[0]"
			:virtual-scroll-item-size="48"
      :virtual-scroll-sticky-size-start="48"
			:pagination.sync="tableList.pagination"
			@virtual-scroll="onScrollTable"
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
			tableList: {
				makeGetNextPage: true,
				loading: false,
				pagination: {
					rowsPerPage: 0,
					rowsNumber: 0,
				},
				data: [],
				scope: null,
				paginateOpts: {},
			},
			showDialogForm: false,
			dataDialogConfirm: {
				show: false,
				body: '',
			},
			formData: {},
		}
	},
	methods: {
		dialogForm(scopeTable = null) {
			this.showDialogForm = true

			if (scopeTable) {
				this.tableList.scopeTable = scopeTable
				this.formData = JSON.parse(JSON.stringify(scopeTable.row))
			} else {
				this.tableList.scopeTable = null
				this.formData = {}
			}
		},
		getDataList({ page }) {
			this.tableList.loading = true
			this.$axios({
				method: 'get',
				url: `paginate/${this.domain}`,
				params: {
					page,
				},
				headers: {
					gpModelParams: JSON.stringify({
						withTrashed: 1,
					}),
				},
			}).then(({ data }: AxiosResponse) => {
				this.tableList.makeGetNextPage = data.data.length === 100

				this.tableList.data = this.tableList.data.concat(data.data)

				this.tableList.paginateOpts = data
				delete this.tableList.paginateOpts.data

				this.tableList.pagination.rowsNumber = this.tableList.paginateOpts.to

			}).catch(console.warn)
			.then(() => this.tableList.loading = false)
		},
		onSubmit() {
			this.$axios({
				method: this.formData.id ? 'put' : 'post',
				url: `${this.domain}/${(this.formData.id || '')}`,
				data: this.formData,
			}).then((resp: AxiosResponse) => {
				this.$set(this.tableList.data, (this.tableList.scopeTable ? this.tableList.scopeTable.rowIndex : this.tableList.data.length), resp.data)

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
							this.$set(this.tableList.data, scopeTable.rowIndex, resp.data)
						} else {
							this.$delete(this.tableList.data, scopeTable.rowIndex)
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
						this.$set(this.tableList.data, scopeTable.rowIndex, resp.data)

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

				if (dataCurrent && dataCurrent.hasOwnProperty(fieldCurrent)) {
					dataCurrent = dataCurrent[fieldCurrent]
				} else {
					break
				}
			}

			return dataCurrent
		},
		onScrollTable({ to, ref }) {
			const { makeGetNextPage, loading, data, paginateOpts } = this.tableList

			if (!loading && makeGetNextPage && to === (data.length - 1)) {
				this.getDataList({ page: (paginateOpts.current_page + 1) })
			}
		},
	},
	mounted() {
		this.getDataList({ page: 1 })
	}
})
</script>

<style lang="scss">
.my-sticky-virtscroll-table {
	height: calc(100vh - 70px);

	.q-table__top,
	.q-table__bottom,
	thead tr:first-child th {
		background-color: #eee;
	}

	thead tr th {
		position: sticky;
		z-index: 1;
	}

	thead tr:last-child th {
		top: 48px;
	}

	thead tr:first-child th {
		top: 0
	}
}
</style>

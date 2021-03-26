import { ActionTree } from 'vuex'
import { LocalStorage } from 'quasar'

import { axiosAPI } from 'boot/axios'

import { StateInterface } from '../index'
import { StateInterface as ConfigMenuStateInterface } from './state'

const actions: ActionTree<ConfigMenuStateInterface, StateInterface> = {
	async list ({ state, commit, getters }, { key }) {

		if (LocalStorage.has(key)) {
			commit('setList', { key, payload: LocalStorage.getItem(key) })
		} else
		if (!state.list[key]) {
			const { data } = await axiosAPI({
				method: "get",
				url: key,
			})

			commit('setList', { key, payload: data })
		}

		return getters['getList']({ key })
	}
}

export default actions

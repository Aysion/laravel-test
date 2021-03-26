import { GetterTree } from 'vuex'
import { StateInterface } from '../index'
import { StateInterface as ConfigMenuStateInterface } from './state'

const getters: GetterTree<ConfigMenuStateInterface, StateInterface> = {
	getList: (state) => ({ key }) => state.list[key],
}

export default getters

import { post, get, put } from '../services/initial_api'
import * as url from './const_api'

export const getListChain = () => get(`${url.GET_LIST_CHAIN}`)

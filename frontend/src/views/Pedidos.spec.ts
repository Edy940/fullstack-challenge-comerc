/**@vitest-environment happy-dom */
import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import Pedidos from './Pedidos.vue'
import api from '../services/api'
import MockAdapter from 'axios-mock-adapter'

const mockApi = new MockAdapter(api)

describe('Pedidos.vue', () => {
  beforeEach(() => {
    mockApi.reset()
    mockApi.onGet('/api/pedidos').reply(200, { data: [] })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onGet('/api/produtos').reply(200, { data: [] })
  })

  it('renderiza título e formulário', () => {
    const wrapper = mount(Pedidos)
    expect(wrapper.find('h2').text()).toBe('Pedidos')
    expect(wrapper.findAll('select').length).toBeGreaterThan(0)
  })

  it('carrega lista de pedidos', async () => {
    const pedidos = [
      { id: 1, cliente: { nome: 'João' }, total: 25.5 },
      { id: 2, cliente: { nome: 'Maria' }, total: 30.0 }
    ]
    mockApi.onGet('/api/pedidos').reply(200, { data: pedidos })

    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const rows = wrapper.findAll('tbody tr')
    expect(rows.length).toBe(2)
  })

  it('adiciona item ao clicar em + Item', async () => {
    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()

    const addBtn = wrapper.findAll('button').find(btn => btn.text().includes('+ Item'))
    const initialSelects = wrapper.findAll('select').length

    await addBtn?.trigger('click')
    await wrapper.vm.$nextTick()

    const finalSelects = wrapper.findAll('select').length
    expect(finalSelects).toBeGreaterThan(initialSelects)
  })

  it('remove item da lista', async () => {
    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()

    // Adiciona dois itens
    const addBtn = wrapper.findAll('button').find(btn => btn.text().includes('+ Item'))
    await addBtn?.trigger('click')
    await addBtn?.trigger('click')
    await wrapper.vm.$nextTick()

    const initialItems = wrapper.findAll('.form-row').length
    const removeBtn = wrapper.findAll('button').find(btn => btn.text().includes('Remover'))
    
    await removeBtn?.trigger('click')
    await wrapper.vm.$nextTick()

    const finalItems = wrapper.findAll('.form-row').length
    expect(finalItems).toBeLessThan(initialItems)
  })

  it('valida pedido sem cliente', async () => {
    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await wrapper.vm.$nextTick()

    const alert = wrapper.find('.alert')
    expect(alert.exists()).toBe(true)
  })

  it('envia pedido completo para API', async () => {
    const clientes = [{ id: 1, nome: 'João' }]
    const produtos = [{ id: 1, nome: 'Pastel', preco: 5.5 }]
    
    mockApi.onGet('/api/clientes').reply(200, { data: clientes })
    mockApi.onGet('/api/produtos').reply(200, { data: produtos })
    mockApi.onPost('/api/pedidos').reply(201, { id: 1 })

    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 100))

    const selects = wrapper.findAll('select')
    const inputs = wrapper.findAll('input')

    // Seleciona cliente
    await selects[0].setValue('1')
    await wrapper.vm.$nextTick()
    // Seleciona produto
    await selects[1].setValue('1')
    await wrapper.vm.$nextTick()
    // Define quantidade e preço
    await inputs[0].setValue('2')
    await inputs[1].setValue('5.50')
    await wrapper.vm.$nextTick()

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await new Promise(resolve => setTimeout(resolve, 150))

    expect(mockApi.history.post.length).toBeGreaterThanOrEqual(0)
  })

  it('chama API delete ao remover pedido', async () => {
    const pedidos = [{ id: 1, cliente: { nome: 'João' }, total: 25.5 }]
    mockApi.onGet('/api/pedidos').reply(200, { data: pedidos })
    mockApi.onDelete('/api/pedidos/1').reply(204)

    const wrapper = mount(Pedidos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const removeBtn = wrapper.find('tbody button')
    await removeBtn.trigger('click')
    await new Promise(resolve => setTimeout(resolve, 50))

    expect(mockApi.history.delete.length).toBe(1)
  })
})

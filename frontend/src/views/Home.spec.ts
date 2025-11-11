/**
 * @vitest-environment happy-dom
 */
import { mount } from "@vue/test-utils";
import Home from "./Home.vue";
import { describe, it, expect } from "vitest";

describe("Home", () => {
  it("renderiza título de boas-vindas", () => {
    const wrapper = mount(Home);
    expect(wrapper.text()).toContain("Bem-vindo(a) à Pastelaria");
  });

  it("renderiza descrição", () => {
    const wrapper = mount(Home);
    expect(wrapper.text()).toContain("Gerencie clientes, produtos e pedidos");
  });
});

/**
 * @vitest-environment happy-dom
 */
import { mount } from "@vue/test-utils";
import InputField from "./InputField.vue";
import { describe, it, expect } from "vitest";

describe("InputField", () => {
  it("renderiza label e input", () => {
    const wrapper = mount(InputField, {
      props: {
        modelValue: "teste",
        label: "Nome",
        id: "nome"
      }
    });
    expect(wrapper.text()).toContain("Nome");
    expect(wrapper.find("input").exists()).toBe(true);
  });

  it("emite update:modelValue ao digitar", async () => {
    const wrapper = mount(InputField, {
      props: {
        modelValue: "",
        label: "Email"
      }
    });
    
    await wrapper.find("input").setValue("test@example.com");
    expect(wrapper.emitted("update:modelValue")).toBeTruthy();
    expect(wrapper.emitted("update:modelValue")?.[0]).toEqual(["test@example.com"]);
  });

  it("aceita type como prop", () => {
    const wrapper = mount(InputField, {
      props: {
        modelValue: "",
        label: "Senha",
        type: "password"
      }
    });
    expect(wrapper.find("input").attributes("type")).toBe("password");
  });
});

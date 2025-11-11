/**
 * @vitest-environment happy-dom
 */
import { mount } from "@vue/test-utils";
import ErrorAlert from "./ErrorAlert.vue";
import { describe, it, expect } from "vitest";

describe("ErrorAlert", () => {
  it("renderiza mensagens", () => {
    const w = mount(ErrorAlert, { props: { messages: ["A", "B"] } });
    expect(w.text()).toContain("A");
    expect(w.text()).toContain("B");
  });
});
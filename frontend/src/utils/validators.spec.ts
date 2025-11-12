import { required, email, minValue } from "./validators";
import { describe, it, expect } from "vitest";

describe("validators", () => {
  it("required", () => {
    expect(required("", "Nome")).toBeTruthy();
    expect(required("x", "Nome")).toBeNull();
  });
  it("email", () => {
    expect(email("foo", "E-mail")).toBeTruthy();
    expect(email("a@b.com", "E-mail")).toBeNull();
  });
  it("minValue", () => {
    expect(minValue(0, "Preço", 0)).toBeNull();
    expect(minValue(-1, "Preço", 0)).toBeTruthy();
  });
});
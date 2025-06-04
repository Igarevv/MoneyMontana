import { defineComponent, reactive, useSSRContext, mergeProps, withCtx, createTextVNode, toDisplayString, createVNode, createBlock, createCommentVNode, openBlock, ref, onMounted, computed, watch, nextTick, createSSRApp, h } from "vue";
import { Message, InputText, Select, ToggleSwitch, StepPanels, Button, StepPanel, Stepper } from "primevue";
import { Form as Form$1 } from "@primevue/forms";
import { yupResolver } from "@primevue/forms/resolvers/yup";
import * as yup from "yup";
import { ssrRenderAttrs, ssrInterpolate, ssrRenderComponent, ssrRenderClass, ssrRenderStyle, ssrRenderAttr, ssrRenderList } from "vue/server-renderer";
import AutoComplete from "primevue/autocomplete";
import Cookies from "js-cookie";
import { useI18n } from "vue-i18n";
import { createInertiaApp } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { renderToString } from "@vue/server-renderer";
const _sfc_main$7 = /* @__PURE__ */ defineComponent({
  __name: "UserRegisterForm",
  props: {
    nextStep: { type: Function, required: true }
  },
  emits: ["user-created"],
  setup(__props, { expose: __expose, emit: __emit }) {
    __expose();
    const props = __props;
    const emit = __emit;
    const initialValues = reactive({
      username: "",
      email: "",
      password: "",
      password_confirm: ""
    });
    const resolver = yupResolver(
      yup.object({
        username: yup.string().required("Username is required").min(3, "Username must be at least 3 characters long"),
        email: yup.string().email("Invalid email address").required("Email is required"),
        password: yup.string().required("Password is required").min(6, "Password must be at least 6 characters long"),
        password_confirm: yup.string().oneOf([yup.ref("password")], "Passwords must match").required("Please confirm your password")
      })
    );
    const onFormSubmit = ({ valid, values }) => {
      props.nextStep(2);
      if (valid) {
        emit("user-created", values);
      }
    };
    const __returned__ = { props, emit, initialValues, resolver, onFormSubmit, get Form() {
      return Form$1;
    }, get InputText() {
      return InputText;
    }, get Message() {
      return Message;
    } };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
const _export_sfc = (sfc, props) => {
  const target = sfc.__vccOpts || sfc;
  for (const [key, val] of props) {
    target[key] = val;
  }
  return target;
};
function _sfc_ssrRender$7(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full max-w-md p-8 space-y-6 dark:bg-primary-dark" }, _attrs))}><h2 class="text-2xl font-bold text-black dark:text-white text-center">${ssrInterpolate(_ctx.$t("registration.register.title"))}</h2><div class="flex space-x-4"><button class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"><img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5"> ${ssrInterpolate(_ctx.$t("registration.register.signup_google"))}</button><button class="flex items-center gap-2 w-full justify-center px-4 py-2 border cursor-pointer border-gray-600 dark:border-gray-400 rounded-lg text-sm text-black dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition"><img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub" class="w-5 h-5"> ${ssrInterpolate(_ctx.$t("registration.register.signup_github"))}</button></div><div class="flex items-center justify-between text-black dark:text-white"><hr class="w-full border-gray-300 dark:border-gray-600"><span class="px-3 text-sm">${ssrInterpolate(_ctx.$t("registration.register.or"))}</span><hr class="w-full border-gray-300 dark:border-gray-600"></div>`);
  _push(ssrRenderComponent($setup["Form"], {
    class: "space-y-4",
    initialValues: $setup.initialValues,
    resolver: $setup.resolver,
    onSubmit: $setup.onFormSubmit
  }, {
    default: withCtx(($form, _push2, _parent2, _scopeId) => {
      var _a, _b, _c, _d, _e, _f, _g, _h;
      if (_push2) {
        _push2(`<div class="flex flex-col gap-1"${_scopeId}><label class="text-base text-black dark:text-white"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.labels.username"))}</label><div class="rounded-xl"${_scopeId}>`);
        _push2(ssrRenderComponent($setup["InputText"], {
          name: "username",
          type: "text",
          placeholder: _ctx.$t("registration.register.placeholders.username"),
          fluid: ""
        }, null, _parent2, _scopeId));
        _push2(`</div>`);
        if ((_a = $form.username) == null ? void 0 : _a.invalid) {
          _push2(ssrRenderComponent($setup["Message"], {
            severity: "error",
            size: "small",
            variant: "simple"
          }, {
            default: withCtx((_, _push3, _parent3, _scopeId2) => {
              if (_push3) {
                _push3(`${ssrInterpolate($form.username.error.message)}`);
              } else {
                return [
                  createTextVNode(
                    toDisplayString($form.username.error.message),
                    1
                    /* TEXT */
                  )
                ];
              }
            }),
            _: 2
            /* DYNAMIC */
          }, _parent2, _scopeId));
        } else {
          _push2(`<!---->`);
        }
        _push2(`</div><div class="flex flex-col gap-1"${_scopeId}><label class="text-base text-black dark:text-white"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.labels.email"))}</label><div class="rounded-xl"${_scopeId}>`);
        _push2(ssrRenderComponent($setup["InputText"], {
          name: "email",
          type: "email",
          placeholder: "john@doe.com",
          fluid: ""
        }, null, _parent2, _scopeId));
        _push2(`</div>`);
        if ((_b = $form.email) == null ? void 0 : _b.invalid) {
          _push2(ssrRenderComponent($setup["Message"], {
            severity: "error",
            size: "small",
            variant: "simple"
          }, {
            default: withCtx((_, _push3, _parent3, _scopeId2) => {
              if (_push3) {
                _push3(`${ssrInterpolate($form.email.error.message)}`);
              } else {
                return [
                  createTextVNode(
                    toDisplayString($form.email.error.message),
                    1
                    /* TEXT */
                  )
                ];
              }
            }),
            _: 2
            /* DYNAMIC */
          }, _parent2, _scopeId));
        } else {
          _push2(`<!---->`);
        }
        _push2(`</div><div class="flex flex-col gap-1"${_scopeId}><label class="text-base text-black dark:text-white"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.labels.password"))}</label><div class="rounded-xl"${_scopeId}>`);
        _push2(ssrRenderComponent($setup["InputText"], {
          name: "password",
          type: "password",
          placeholder: "*********",
          fluid: ""
        }, null, _parent2, _scopeId));
        _push2(`</div>`);
        if ((_c = $form.password) == null ? void 0 : _c.invalid) {
          _push2(ssrRenderComponent($setup["Message"], {
            severity: "error",
            size: "small",
            variant: "simple"
          }, {
            default: withCtx((_, _push3, _parent3, _scopeId2) => {
              if (_push3) {
                _push3(`${ssrInterpolate($form.password.error.message)}`);
              } else {
                return [
                  createTextVNode(
                    toDisplayString($form.password.error.message),
                    1
                    /* TEXT */
                  )
                ];
              }
            }),
            _: 2
            /* DYNAMIC */
          }, _parent2, _scopeId));
        } else {
          _push2(`<!---->`);
        }
        _push2(`</div><div class="flex flex-col gap-1"${_scopeId}><label class="text-base text-black dark:text-white"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.labels.password_confirm"))}</label><div class="rounded-xl"${_scopeId}>`);
        _push2(ssrRenderComponent($setup["InputText"], {
          name: "password_confirm",
          type: "password",
          placeholder: "*********",
          fluid: ""
        }, null, _parent2, _scopeId));
        _push2(`</div>`);
        if ((_d = $form.password_confirm) == null ? void 0 : _d.invalid) {
          _push2(ssrRenderComponent($setup["Message"], {
            severity: "error",
            size: "small",
            variant: "simple"
          }, {
            default: withCtx((_, _push3, _parent3, _scopeId2) => {
              if (_push3) {
                _push3(`${ssrInterpolate($form.password_confirm.error.message)}`);
              } else {
                return [
                  createTextVNode(
                    toDisplayString($form.password_confirm.error.message),
                    1
                    /* TEXT */
                  )
                ];
              }
            }),
            _: 2
            /* DYNAMIC */
          }, _parent2, _scopeId));
        } else {
          _push2(`<!---->`);
        }
        _push2(`</div><div class="space-y-2"${_scopeId}><label class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300"${_scopeId}><input type="checkbox" class="form-checkbox rounded text-blue-500"${_scopeId}><span${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.checkbox.agree_text"))} <a href="#" class="text-blue-500 underline"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.checkbox.terms_of_use"))}</a> и <a href="#" class="text-blue-500 underline"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.checkbox.privacy_policy"))}</a>. </span></label></div><button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded font-medium"${_scopeId}>${ssrInterpolate(_ctx.$t("registration.register.buttons.next_step"))}</button>`);
      } else {
        return [
          createVNode("div", { class: "flex flex-col gap-1" }, [
            createVNode(
              "label",
              { class: "text-base text-black dark:text-white" },
              toDisplayString(_ctx.$t("registration.register.labels.username")),
              1
              /* TEXT */
            ),
            createVNode("div", { class: "rounded-xl" }, [
              createVNode($setup["InputText"], {
                name: "username",
                type: "text",
                placeholder: _ctx.$t("registration.register.placeholders.username"),
                fluid: ""
              }, null, 8, ["placeholder"])
            ]),
            ((_e = $form.username) == null ? void 0 : _e.invalid) ? (openBlock(), createBlock(
              $setup["Message"],
              {
                key: 0,
                severity: "error",
                size: "small",
                variant: "simple"
              },
              {
                default: withCtx(() => [
                  createTextVNode(
                    toDisplayString($form.username.error.message),
                    1
                    /* TEXT */
                  )
                ]),
                _: 2
                /* DYNAMIC */
              },
              1024
              /* DYNAMIC_SLOTS */
            )) : createCommentVNode("v-if", true)
          ]),
          createVNode("div", { class: "flex flex-col gap-1" }, [
            createVNode(
              "label",
              { class: "text-base text-black dark:text-white" },
              toDisplayString(_ctx.$t("registration.register.labels.email")),
              1
              /* TEXT */
            ),
            createVNode("div", { class: "rounded-xl" }, [
              createVNode($setup["InputText"], {
                name: "email",
                type: "email",
                placeholder: "john@doe.com",
                fluid: ""
              })
            ]),
            ((_f = $form.email) == null ? void 0 : _f.invalid) ? (openBlock(), createBlock(
              $setup["Message"],
              {
                key: 0,
                severity: "error",
                size: "small",
                variant: "simple"
              },
              {
                default: withCtx(() => [
                  createTextVNode(
                    toDisplayString($form.email.error.message),
                    1
                    /* TEXT */
                  )
                ]),
                _: 2
                /* DYNAMIC */
              },
              1024
              /* DYNAMIC_SLOTS */
            )) : createCommentVNode("v-if", true)
          ]),
          createVNode("div", { class: "flex flex-col gap-1" }, [
            createVNode(
              "label",
              { class: "text-base text-black dark:text-white" },
              toDisplayString(_ctx.$t("registration.register.labels.password")),
              1
              /* TEXT */
            ),
            createVNode("div", { class: "rounded-xl" }, [
              createVNode($setup["InputText"], {
                name: "password",
                type: "password",
                placeholder: "*********",
                fluid: ""
              })
            ]),
            ((_g = $form.password) == null ? void 0 : _g.invalid) ? (openBlock(), createBlock(
              $setup["Message"],
              {
                key: 0,
                severity: "error",
                size: "small",
                variant: "simple"
              },
              {
                default: withCtx(() => [
                  createTextVNode(
                    toDisplayString($form.password.error.message),
                    1
                    /* TEXT */
                  )
                ]),
                _: 2
                /* DYNAMIC */
              },
              1024
              /* DYNAMIC_SLOTS */
            )) : createCommentVNode("v-if", true)
          ]),
          createVNode("div", { class: "flex flex-col gap-1" }, [
            createVNode(
              "label",
              { class: "text-base text-black dark:text-white" },
              toDisplayString(_ctx.$t("registration.register.labels.password_confirm")),
              1
              /* TEXT */
            ),
            createVNode("div", { class: "rounded-xl" }, [
              createVNode($setup["InputText"], {
                name: "password_confirm",
                type: "password",
                placeholder: "*********",
                fluid: ""
              })
            ]),
            ((_h = $form.password_confirm) == null ? void 0 : _h.invalid) ? (openBlock(), createBlock(
              $setup["Message"],
              {
                key: 0,
                severity: "error",
                size: "small",
                variant: "simple"
              },
              {
                default: withCtx(() => [
                  createTextVNode(
                    toDisplayString($form.password_confirm.error.message),
                    1
                    /* TEXT */
                  )
                ]),
                _: 2
                /* DYNAMIC */
              },
              1024
              /* DYNAMIC_SLOTS */
            )) : createCommentVNode("v-if", true)
          ]),
          createVNode("div", { class: "space-y-2" }, [
            createVNode("label", { class: "flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300" }, [
              createVNode("input", {
                type: "checkbox",
                class: "form-checkbox rounded text-blue-500"
              }),
              createVNode("span", null, [
                createTextVNode(
                  toDisplayString(_ctx.$t("registration.register.checkbox.agree_text")) + " ",
                  1
                  /* TEXT */
                ),
                createVNode(
                  "a",
                  {
                    href: "#",
                    class: "text-blue-500 underline"
                  },
                  toDisplayString(_ctx.$t("registration.register.checkbox.terms_of_use")),
                  1
                  /* TEXT */
                ),
                createTextVNode(" и "),
                createVNode(
                  "a",
                  {
                    href: "#",
                    class: "text-blue-500 underline"
                  },
                  toDisplayString(_ctx.$t("registration.register.checkbox.privacy_policy")),
                  1
                  /* TEXT */
                ),
                createTextVNode(". ")
              ])
            ])
          ]),
          createVNode(
            "button",
            {
              type: "submit",
              class: "w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded font-medium"
            },
            toDisplayString(_ctx.$t("registration.register.buttons.next_step")),
            1
            /* TEXT */
          )
        ];
      }
    }),
    _: 1
    /* STABLE */
  }, _parent));
  _push(`<p class="text-sm text-gray-500 dark:text-gray-300 text-center">${ssrInterpolate(_ctx.$t("registration.register.already_have_account"))} <a href="#" class="text-blue-500 underline">${ssrInterpolate(_ctx.$t("registration.register.buttons.login_here"))}</a></p></div>`);
}
const _sfc_setup$7 = _sfc_main$7.setup;
_sfc_main$7.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("modules/Auth/resources/views/components/Registration/Steps/UserRegisterForm.vue");
  return _sfc_setup$7 ? _sfc_setup$7(props, ctx) : void 0;
};
const Form = /* @__PURE__ */ _export_sfc(_sfc_main$7, [["ssrRender", _sfc_ssrRender$7], ["__file", "/app/modules/Auth/resources/views/components/Registration/Steps/UserRegisterForm.vue"]]);
var SupportedLocales = /* @__PURE__ */ ((SupportedLocales2) => {
  SupportedLocales2["EN"] = "en";
  SupportedLocales2["RU"] = "ru";
  SupportedLocales2["UK"] = "uk";
  return SupportedLocales2;
})(SupportedLocales || {});
const languages = [
  { languageCode: SupportedLocales.EN, languageName: "English" },
  { languageCode: SupportedLocales.RU, languageName: "Русский" },
  { languageCode: SupportedLocales.UK, languageName: "Українська" }
];
function useLocaleChange() {
  const { locale: i18nLocale } = useI18n();
  const currentLocale = ref(
    Cookies.get("locale") || SupportedLocales.EN
  );
  const availableCodes = languages.map((lang) => lang.languageCode);
  const changeLocale = (newLocale) => {
    if (availableCodes.includes(newLocale)) {
      Cookies.set("locale", newLocale, {
        expires: 365,
        path: "/",
        sameSite: "Lax",
        secure: false
      });
      currentLocale.value = newLocale;
      i18nLocale.value = newLocale;
    } else {
      console.warn(`Locale ${newLocale} is not supported.`);
    }
  };
  return {
    currentLocale,
    changeLocale
  };
}
const _sfc_main$6 = /* @__PURE__ */ defineComponent({
  __name: "DefaultSelectLocalization",
  setup(__props, { expose: __expose }) {
    __expose();
    const locale = useLocaleChange();
    const __returned__ = { locale, get availableLanguages() {
      return languages;
    }, get Select() {
      return Select;
    } };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender$6(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(ssrRenderComponent($setup["Select"], mergeProps({
    modelValue: $setup.locale.currentLocale,
    "onUpdate:modelValue": ($event) => $setup.locale.currentLocale = $event,
    options: $setup.availableLanguages,
    optionLabel: "languageName",
    "option-value": "languageCode",
    checkmark: "",
    highlightOnSelect: false,
    class: "w-full",
    onChange: ($event) => $setup.locale.changeLocale($event.value)
  }, _attrs), null, _parent));
}
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/Localization/DefaultSelectLocalization.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const DefaultSelectLocalization = /* @__PURE__ */ _export_sfc(_sfc_main$6, [["ssrRender", _sfc_ssrRender$6], ["__file", "/app/resources/js/Shared/Localization/DefaultSelectLocalization.vue"]]);
function switchTheme(enableDark) {
  if (enableDark) {
    document.documentElement.classList.add("dark");
    localStorage.theme = "dark";
  } else {
    document.documentElement.classList.remove("dark");
    localStorage.theme = "light";
  }
}
function getCurrentTheme() {
  if (localStorage.theme === "dark" || !("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches) {
    return "dark";
  }
  return "light";
}
const _sfc_main$5 = /* @__PURE__ */ defineComponent({
  __name: "DefaultToggleDark",
  setup(__props, { expose: __expose }) {
    __expose();
    const isDark = ref(false);
    onMounted(() => {
      isDark.value = getCurrentTheme() === "dark";
    });
    const isLightToggle = computed({
      get: () => !isDark.value,
      set: (val) => {
        isDark.value = !val;
      }
    });
    watch(isDark, (newVal) => {
      switchTheme(newVal);
    });
    const __returned__ = { isDark, isLightToggle, get ToggleSwitch() {
      return ToggleSwitch;
    } };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender$5(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(ssrRenderComponent($setup["ToggleSwitch"], mergeProps({
    modelValue: $setup.isLightToggle,
    "onUpdate:modelValue": ($event) => $setup.isLightToggle = $event
  }, _attrs), {
    handle: withCtx(({ checked }, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<i class="${ssrRenderClass(["!text-xs pi", { "pi-sun": checked, "pi-moon": !checked }])}" data-v-ee576898${_scopeId}></i>`);
      } else {
        return [
          createVNode(
            "i",
            {
              class: ["!text-xs pi", { "pi-sun": checked, "pi-moon": !checked }]
            },
            null,
            2
            /* CLASS */
          )
        ];
      }
    }),
    _: 1
    /* STABLE */
  }, _parent));
}
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/DarkMode/DefaultToggleDark.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const DefaultToggleDark = /* @__PURE__ */ _export_sfc(_sfc_main$5, [["ssrRender", _sfc_ssrRender$5], ["__scopeId", "data-v-ee576898"], ["__file", "/app/resources/js/Shared/DarkMode/DefaultToggleDark.vue"]]);
const _sfc_main$4 = /* @__PURE__ */ defineComponent({
  __name: "UserPreferencesForm",
  setup(__props, { expose: __expose }) {
    __expose();
    const { t } = useI18n();
    const selectedCountry = ref(null);
    const { currentLocale } = useLocaleChange();
    const selectedCurrency = ref(null);
    const filteredCountries = ref([]);
    let allCountries = [];
    async function loadCountries() {
      if (allCountries.length > 0) {
        return;
      }
      const data = await import("./assets/countries-B7EZ5jOQ.js");
      allCountries = data.default.country.map((item) => ({
        ...item,
        label: `${item.countryName} (${item.currencyCode})`
      }));
    }
    async function searchCountry(event) {
      await loadCountries();
      const query = event.query.toLowerCase();
      filteredCountries.value = allCountries.filter(
        (c) => c.countryName.toLowerCase().includes(query) || c.currencyCode.toLowerCase().includes(query) || c.capital.toLowerCase().includes(query)
      );
    }
    const __returned__ = { t, selectedCountry, currentLocale, selectedCurrency, filteredCountries, get allCountries() {
      return allCountries;
    }, set allCountries(v) {
      allCountries = v;
    }, loadCountries, searchCountry, get AutoComplete() {
      return AutoComplete;
    }, DefaultSelectLocalization, DefaultToggleDark };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender$4(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full max-w-md p-8 space-y-6 dark:bg-primary-dark" }, _attrs))}><h2 class="text-2xl font-bold text-black dark:text-white text-center">${ssrInterpolate($setup.t("registration.setup_preferences.title"))}</h2><div class="space-y-6 flex items-center flex-col"><div class="flex flex-col w-full"><label class="text-base text-black dark:text-white">${ssrInterpolate($setup.t("registration.setup_preferences.country_label"))}</label><div class="flex flex-row items-center gap-3 w-full">`);
  _push(ssrRenderComponent($setup["AutoComplete"], {
    modelValue: $setup.selectedCountry,
    "onUpdate:modelValue": ($event) => $setup.selectedCountry = $event,
    suggestions: $setup.filteredCountries,
    onComplete: $setup.searchCountry,
    optionLabel: "countryName",
    placeholder: $setup.t("registration.setup_preferences.country_placeholder"),
    dropdown: "",
    class: "w-full"
  }, null, _parent));
  _push(`<i class="${ssrRenderClass([$setup.selectedCountry !== null ? "text-green-500" : "text-gray-800", "pi pi-check"])}"></i></div></div><div class="flex flex-col w-full"><label class="text-base text-black dark:text-white">${ssrInterpolate($setup.t("registration.setup_preferences.language_label"))}</label><div class="flex flex-row items-center gap-3">`);
  _push(ssrRenderComponent($setup["DefaultSelectLocalization"], null, null, _parent));
  _push(`<i class="${ssrRenderClass([$setup.currentLocale !== null ? "text-green-500" : "text-gray-800", "pi pi-check"])}"></i></div></div><div class="flex flex-col w-full"><label class="text-base text-black dark:text-white">${ssrInterpolate($setup.t("registration.setup_preferences.currency_label"))}</label><div class="flex flex-row items-center gap-3 w-full">`);
  _push(ssrRenderComponent($setup["AutoComplete"], {
    modelValue: $setup.selectedCurrency,
    "onUpdate:modelValue": ($event) => $setup.selectedCurrency = $event,
    suggestions: $setup.filteredCountries,
    onComplete: $setup.searchCountry,
    optionLabel: "currencyCode",
    placeholder: $setup.t("registration.setup_preferences.currency_placeholder"),
    class: "w-full",
    dropdown: ""
  }, {
    option: withCtx((slotProps, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(`<div class="flex flex-col"${_scopeId}><span class="font-semibold"${_scopeId}>${ssrInterpolate(slotProps.option.currencyCode)}</span><small class="text-gray-500"${_scopeId}>${ssrInterpolate($setup.t("registration.setup_preferences.currency_country_prefix"))} ${ssrInterpolate(slotProps.option.countryName)}</small></div>`);
      } else {
        return [
          createVNode("div", { class: "flex flex-col" }, [
            createVNode(
              "span",
              { class: "font-semibold" },
              toDisplayString(slotProps.option.currencyCode),
              1
              /* TEXT */
            ),
            createVNode(
              "small",
              { class: "text-gray-500" },
              toDisplayString($setup.t("registration.setup_preferences.currency_country_prefix")) + " " + toDisplayString(slotProps.option.countryName),
              1
              /* TEXT */
            )
          ])
        ];
      }
    }),
    _: 1
    /* STABLE */
  }, _parent));
  _push(`<i class="${ssrRenderClass([$setup.selectedCountry !== null ? "text-green-500" : "text-gray-800", "pi pi-check"])}"></i></div></div><div class="flex flex-row gap-3"><span>${ssrInterpolate($setup.t("registration.setup_preferences.theme_mode"))}</span>`);
  _push(ssrRenderComponent($setup["DefaultToggleDark"], null, null, _parent));
  _push(`</div></div></div>`);
}
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const UserPreferencesForm = /* @__PURE__ */ _export_sfc(_sfc_main$4, [["ssrRender", _sfc_ssrRender$4], ["__file", "/app/modules/Auth/resources/views/components/Registration/Steps/UserPreferencesForm.vue"]]);
const _sfc_main$3 = /* @__PURE__ */ defineComponent({
  __name: "RegisterForm",
  setup(__props, { expose: __expose }) {
    __expose();
    const userRegisterData = reactive({
      user: null
    });
    const activeStep = ref(1);
    const onUserCreated = (user) => {
      userRegisterData.user = user;
      activeStep.value = 2;
    };
    const __returned__ = { userRegisterData, activeStep, onUserCreated, get Stepper() {
      return Stepper;
    }, get StepPanel() {
      return StepPanel;
    }, get Button() {
      return Button;
    }, get StepPanels() {
      return StepPanels;
    }, Form, UserPreferencesForm };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender$3(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "card flex justify-center" }, _attrs))}>`);
  _push(ssrRenderComponent($setup["Stepper"], {
    value: $setup.activeStep,
    "onUpdate:value": ($event) => $setup.activeStep = $event,
    class: "basis-[40rem]"
  }, {
    default: withCtx((_, _push2, _parent2, _scopeId) => {
      if (_push2) {
        _push2(ssrRenderComponent($setup["StepPanels"], null, {
          default: withCtx((_2, _push3, _parent3, _scopeId2) => {
            if (_push3) {
              _push3(ssrRenderComponent($setup["StepPanel"], { value: 1 }, {
                default: withCtx(({ activateCallback }, _push4, _parent4, _scopeId3) => {
                  if (_push4) {
                    _push4(ssrRenderComponent($setup["Form"], {
                      "next-step": activateCallback,
                      onUserCreated: $setup.onUserCreated
                    }, null, _parent4, _scopeId3));
                  } else {
                    return [
                      createVNode($setup["Form"], {
                        "next-step": activateCallback,
                        onUserCreated: $setup.onUserCreated
                      }, null, 8, ["next-step"])
                    ];
                  }
                }),
                _: 1
                /* STABLE */
              }, _parent3, _scopeId2));
              _push3(ssrRenderComponent($setup["StepPanel"], { value: 2 }, {
                default: withCtx(({ activateCallback }, _push4, _parent4, _scopeId3) => {
                  if (_push4) {
                    _push4(ssrRenderComponent($setup["UserPreferencesForm"], null, null, _parent4, _scopeId3));
                    _push4(`<div class="flex pt-6 justify-between"${_scopeId3}>`);
                    _push4(ssrRenderComponent($setup["Button"], {
                      label: "Back",
                      severity: "secondary",
                      icon: "pi pi-arrow-left",
                      onClick: ($event) => activateCallback(1)
                    }, null, _parent4, _scopeId3));
                    _push4(ssrRenderComponent($setup["Button"], {
                      label: "Next",
                      icon: "pi pi-arrow-right",
                      iconPos: "right",
                      onClick: ($event) => activateCallback(3)
                    }, null, _parent4, _scopeId3));
                    _push4(`</div>`);
                  } else {
                    return [
                      createVNode($setup["UserPreferencesForm"]),
                      createVNode("div", { class: "flex pt-6 justify-between" }, [
                        createVNode($setup["Button"], {
                          label: "Back",
                          severity: "secondary",
                          icon: "pi pi-arrow-left",
                          onClick: ($event) => activateCallback(1)
                        }, null, 8, ["onClick"]),
                        createVNode($setup["Button"], {
                          label: "Next",
                          icon: "pi pi-arrow-right",
                          iconPos: "right",
                          onClick: ($event) => activateCallback(3)
                        }, null, 8, ["onClick"])
                      ])
                    ];
                  }
                }),
                _: 1
                /* STABLE */
              }, _parent3, _scopeId2));
              _push3(ssrRenderComponent($setup["StepPanel"], { value: 3 }, {
                default: withCtx(({ activateCallback }, _push4, _parent4, _scopeId3) => {
                  if (_push4) {
                    _push4(`<div class="flex flex-col gap-2 mx-auto" style="${ssrRenderStyle({ "min-height": "16rem", "max-width": "24rem" })}"${_scopeId3}><div class="text-center mt-4 mb-4 text-xl font-semibold"${_scopeId3}>Account created successfully</div><div class="flex justify-center"${_scopeId3}><img alt="logo" src="https://primefaces.org/cdn/primevue/images/stepper/content.svg"${_scopeId3}></div></div><div class="flex pt-6 justify-start"${_scopeId3}>`);
                    _push4(ssrRenderComponent($setup["Button"], {
                      label: "Back",
                      severity: "secondary",
                      icon: "pi pi-arrow-left",
                      onClick: ($event) => activateCallback(2)
                    }, null, _parent4, _scopeId3));
                    _push4(`</div>`);
                  } else {
                    return [
                      createVNode("div", {
                        class: "flex flex-col gap-2 mx-auto",
                        style: { "min-height": "16rem", "max-width": "24rem" }
                      }, [
                        createVNode("div", { class: "text-center mt-4 mb-4 text-xl font-semibold" }, "Account created successfully"),
                        createVNode("div", { class: "flex justify-center" }, [
                          createVNode("img", {
                            alt: "logo",
                            src: "https://primefaces.org/cdn/primevue/images/stepper/content.svg"
                          })
                        ])
                      ]),
                      createVNode("div", { class: "flex pt-6 justify-start" }, [
                        createVNode($setup["Button"], {
                          label: "Back",
                          severity: "secondary",
                          icon: "pi pi-arrow-left",
                          onClick: ($event) => activateCallback(2)
                        }, null, 8, ["onClick"])
                      ])
                    ];
                  }
                }),
                _: 1
                /* STABLE */
              }, _parent3, _scopeId2));
            } else {
              return [
                createVNode($setup["StepPanel"], { value: 1 }, {
                  default: withCtx(({ activateCallback }) => [
                    createVNode($setup["Form"], {
                      "next-step": activateCallback,
                      onUserCreated: $setup.onUserCreated
                    }, null, 8, ["next-step"])
                  ]),
                  _: 1
                  /* STABLE */
                }),
                createVNode($setup["StepPanel"], { value: 2 }, {
                  default: withCtx(({ activateCallback }) => [
                    createVNode($setup["UserPreferencesForm"]),
                    createVNode("div", { class: "flex pt-6 justify-between" }, [
                      createVNode($setup["Button"], {
                        label: "Back",
                        severity: "secondary",
                        icon: "pi pi-arrow-left",
                        onClick: ($event) => activateCallback(1)
                      }, null, 8, ["onClick"]),
                      createVNode($setup["Button"], {
                        label: "Next",
                        icon: "pi pi-arrow-right",
                        iconPos: "right",
                        onClick: ($event) => activateCallback(3)
                      }, null, 8, ["onClick"])
                    ])
                  ]),
                  _: 1
                  /* STABLE */
                }),
                createVNode($setup["StepPanel"], { value: 3 }, {
                  default: withCtx(({ activateCallback }) => [
                    createVNode("div", {
                      class: "flex flex-col gap-2 mx-auto",
                      style: { "min-height": "16rem", "max-width": "24rem" }
                    }, [
                      createVNode("div", { class: "text-center mt-4 mb-4 text-xl font-semibold" }, "Account created successfully"),
                      createVNode("div", { class: "flex justify-center" }, [
                        createVNode("img", {
                          alt: "logo",
                          src: "https://primefaces.org/cdn/primevue/images/stepper/content.svg"
                        })
                      ])
                    ]),
                    createVNode("div", { class: "flex pt-6 justify-start" }, [
                      createVNode($setup["Button"], {
                        label: "Back",
                        severity: "secondary",
                        icon: "pi pi-arrow-left",
                        onClick: ($event) => activateCallback(2)
                      }, null, 8, ["onClick"])
                    ])
                  ]),
                  _: 1
                  /* STABLE */
                })
              ];
            }
          }),
          _: 1
          /* STABLE */
        }, _parent2, _scopeId));
      } else {
        return [
          createVNode($setup["StepPanels"], null, {
            default: withCtx(() => [
              createVNode($setup["StepPanel"], { value: 1 }, {
                default: withCtx(({ activateCallback }) => [
                  createVNode($setup["Form"], {
                    "next-step": activateCallback,
                    onUserCreated: $setup.onUserCreated
                  }, null, 8, ["next-step"])
                ]),
                _: 1
                /* STABLE */
              }),
              createVNode($setup["StepPanel"], { value: 2 }, {
                default: withCtx(({ activateCallback }) => [
                  createVNode($setup["UserPreferencesForm"]),
                  createVNode("div", { class: "flex pt-6 justify-between" }, [
                    createVNode($setup["Button"], {
                      label: "Back",
                      severity: "secondary",
                      icon: "pi pi-arrow-left",
                      onClick: ($event) => activateCallback(1)
                    }, null, 8, ["onClick"]),
                    createVNode($setup["Button"], {
                      label: "Next",
                      icon: "pi pi-arrow-right",
                      iconPos: "right",
                      onClick: ($event) => activateCallback(3)
                    }, null, 8, ["onClick"])
                  ])
                ]),
                _: 1
                /* STABLE */
              }),
              createVNode($setup["StepPanel"], { value: 3 }, {
                default: withCtx(({ activateCallback }) => [
                  createVNode("div", {
                    class: "flex flex-col gap-2 mx-auto",
                    style: { "min-height": "16rem", "max-width": "24rem" }
                  }, [
                    createVNode("div", { class: "text-center mt-4 mb-4 text-xl font-semibold" }, "Account created successfully"),
                    createVNode("div", { class: "flex justify-center" }, [
                      createVNode("img", {
                        alt: "logo",
                        src: "https://primefaces.org/cdn/primevue/images/stepper/content.svg"
                      })
                    ])
                  ]),
                  createVNode("div", { class: "flex pt-6 justify-start" }, [
                    createVNode($setup["Button"], {
                      label: "Back",
                      severity: "secondary",
                      icon: "pi pi-arrow-left",
                      onClick: ($event) => activateCallback(2)
                    }, null, 8, ["onClick"])
                  ])
                ]),
                _: 1
                /* STABLE */
              })
            ]),
            _: 1
            /* STABLE */
          })
        ];
      }
    }),
    _: 1
    /* STABLE */
  }, _parent));
  _push(`</div>`);
}
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("modules/Auth/resources/views/components/Registration/RegisterForm.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const RegisterForm = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["ssrRender", _sfc_ssrRender$3], ["__file", "/app/modules/Auth/resources/views/components/Registration/RegisterForm.vue"]]);
const _imports_0 = "/build/assets/logo_mountain-CDamX396.png";
const _sfc_main$2 = {};
function _sfc_ssrRender$2(_ctx, _push, _parent, _attrs) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col items-center w-full" }, _attrs))}><img${ssrRenderAttr("src", _imports_0)} alt="Mountain Logo" class="w-32 sm:w-52 z-0 filter invert"><div class="flex justify-center underline underline-offset-4 font-semibold z-10 w-full"><span class="font-playfair uppercase text-white text-xl sm:text-2xl">Money Montana</span></div></div>`);
}
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Shared/AppLogoLight.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const AppLogoLight = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["ssrRender", _sfc_ssrRender$2], ["__file", "/app/resources/js/Shared/AppLogoLight.vue"]]);
const _sfc_main$1 = /* @__PURE__ */ defineComponent({
  __name: "PromoPanel",
  setup(__props, { expose: __expose }) {
    __expose();
    const icons = [
      "pi-wallet",
      "pi-money-bill",
      "pi-credit-card",
      "pi-pound",
      "pi-dollar"
    ];
    const { t } = useI18n();
    const gradients = [
      "from-[#544a7d] to-[#ffd452]",
      "from-[#108dc7] to-[#ef8e38]",
      "from-[#22c1c3] to-[#fdbb2d]",
      "from-[#EB5757] to-[#000000]",
      "from-[#34e89e] to-[#0f3443]",
      "from-[#F3904F] to-[#3B4371]",
      "from-[#3494E6] to-[#EC6EAD]",
      "from-[#3a6186] to-[#89253e]",
      "from-[#2C3E50] to-[#FD746C]",
      "from-[#536976] to-[#292E49]",
      "from-[#43C6AC] to-[#191654]",
      "from-[#1d4350] to-[#a43931]"
    ];
    const fallingIcons = ref([]);
    const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];
    const animationStarted = ref(false);
    function randomBetween(min, max) {
      return Math.random() * (max - min) + min;
    }
    onMounted(async () => {
      const count = 20;
      for (let i = 0; i < count; i++) {
        fallingIcons.value.push({
          id: i,
          icon: icons[Math.floor(Math.random() * icons.length)],
          left: `${randomBetween(0, 100)}%`,
          size: `${randomBetween(1, 2.5)}rem`,
          duration: randomBetween(6, 12),
          delay: randomBetween(0, 12),
          opacity: randomBetween(0.4, 0.9)
        });
      }
      await nextTick();
      setTimeout(() => {
        animationStarted.value = true;
      }, 50);
    });
    const __returned__ = { icons, t, gradients, fallingIcons, randomGradient, animationStarted, randomBetween, AppLogoLight };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender$1(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<div${ssrRenderAttrs(mergeProps({
    class: [["bg-gradient-to-tr", $setup.randomGradient], "flex flex-col min-h-screen bg-gradient-to-tr text-white relative overflow-hidden"]
  }, _attrs))} data-v-c3420981><div class="absolute inset-0 pointer-events-none" data-v-c3420981><!--[-->`);
  ssrRenderList($setup.fallingIcons, (icon) => {
    _push(`<i class="${ssrRenderClass(["pi", icon.icon, "falling-icon", { "animate": $setup.animationStarted }])}" style="${ssrRenderStyle({
      "--left": icon.left,
      "--size": icon.size,
      "--duration": `${icon.duration}s`,
      "--delay": `${icon.delay}s`,
      "--opacity": icon.opacity
    })}" data-v-c3420981></i>`);
  });
  _push(`<!--]--></div><header class="pt-10 flex justify-center z-10 relative" data-v-c3420981>`);
  _push(ssrRenderComponent($setup["AppLogoLight"], { class: "h-16 w-auto max-w-[70%] sm:max-w-none" }, null, _parent));
  _push(`</header><main class="flex flex-1 items-center justify-center px-4 sm:px-10 z-10 relative text-center" data-v-c3420981><div class="flex flex-col items-center space-y-6 max-w-3xl" data-v-c3420981><h1 class="text-3xl sm:text-5xl font-extrabold leading-snug sm:leading-tight" data-v-c3420981>${ssrInterpolate($setup.t("registration.promo.heading"))}</h1><p class="text-sm sm:text-base text-gray-100 max-w-lg sm:max-w-2xl" data-v-c3420981>${ssrInterpolate($setup.t("registration.promo.description"))}</p></div></main><footer class="py-6 text-sm sm:text-base" data-v-c3420981><div class="flex justify-center items-center text-center px-4" data-v-c3420981><span class="text-xl" data-v-c3420981>©</span> ${ssrInterpolate((/* @__PURE__ */ new Date()).getFullYear())} ${ssrInterpolate($setup.t("registration.promo.footer"))}</div></footer></div>`);
}
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("modules/Auth/resources/views/components/Registration/PromoPanel.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const PromoPanel = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["ssrRender", _sfc_ssrRender$1], ["__scopeId", "data-v-c3420981"], ["__file", "/app/modules/Auth/resources/views/components/Registration/PromoPanel.vue"]]);
const _sfc_main = /* @__PURE__ */ defineComponent({
  __name: "RegisterPage",
  setup(__props, { expose: __expose }) {
    __expose();
    const __returned__ = { RegisterForm, PromoPanel };
    Object.defineProperty(__returned__, "__isScriptSetup", { enumerable: false, value: true });
    return __returned__;
  }
});
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push(`<main${ssrRenderAttrs(mergeProps({ class: "flex min-h-screen" }, _attrs))}><div class="hidden md:block w-1/2">`);
  _push(ssrRenderComponent($setup["PromoPanel"], null, null, _parent));
  _push(`</div><div class="w-full md:w-1/2 flex justify-center items-center">`);
  _push(ssrRenderComponent($setup["RegisterForm"], null, null, _parent));
  _push(`</div></main>`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Auth/RegisterPage.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const RegisterPage = /* @__PURE__ */ _export_sfc(_sfc_main, [["ssrRender", _sfc_ssrRender], ["__file", "/app/resources/js/Pages/Auth/RegisterPage.vue"]]);
const __vite_glob_0_0 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: RegisterPage
}, Symbol.toStringTag, { value: "Module" }));
createServer(
  (page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => {
      const pages = /* @__PURE__ */ Object.assign({ "./Pages/Auth/RegisterPage.vue": __vite_glob_0_0 });
      return pages[`./Pages/${name}.vue`];
    },
    setup({ App, props, plugin }) {
      return createSSRApp({
        render: () => h(App, props)
      }).use(plugin);
    }
  })
);

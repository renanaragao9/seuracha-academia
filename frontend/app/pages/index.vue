<script setup lang="ts">
import type { AcademyConfig } from "~/interfaces/academy-config";
import type { LandingData, LandingStats, LandingPlan } from "~/interfaces/landing-data";
import { fetchLandingData } from "~/services/landingService";

definePageMeta({
  layout: "landing",
});

const {
  public: { apiBase },
} = useRuntimeConfig();

const selectedPlan = ref<string>("");

const { data: landingRaw, error } = await useAsyncData<LandingData | null>(
  "landing-data",
  () => fetchLandingData(apiBase),
  { dedupe: "defer" },
);

if (error.value) {
  console.error("Erro ao buscar dados da landing page:", error.value);
}

const config = computed<AcademyConfig | undefined>(() => landingRaw.value?.configuration ?? undefined);
const stats = computed<LandingStats | null>(() => landingRaw.value?.stats ?? null);
const plans = computed<LandingPlan[]>(() => landingRaw.value?.plans ?? []);

provide<Ref<AcademyConfig | undefined>>("academyConfig", config);
provide<Ref<LandingStats | null>>("landingStats", stats);
provide<Ref<LandingPlan[]>>("landingPlans", plans);
provide<Ref<string>>("selectedPlan", selectedPlan);

const academyName = computed(() => config.value?.name ?? "Academia");
const academyDescription = computed(
  () =>
    config.value?.description ??
    "A academia completa com musculação, cardio, yoga, artes marciais, natação e muito mais. Equipamentos de última geração e professores certificados. Primeira semana grátis!",
);
const academyLogo = computed(() => config.value?.branding?.logoUrl ?? null);
const academyCity = computed(() => config.value?.address?.city ?? null);
const academyState = computed(() => config.value?.address?.state ?? null);
const academyPhone = computed(() => config.value?.contact?.phone ?? null);
const academyAddress = computed(() => config.value?.address?.full ?? null);
const academyWebsite = computed(() => config.value?.social?.website ?? "https://ironfit.com.br");
const fullTitle = computed(() => {
  const name = academyName.value;
  const city = academyCity.value;
  const state = academyState.value;
  const location = city && state ? ` em ${city} - ${state}` : city ? ` em ${city}` : "";
  return `${name}${location} — musculação, cardio e muito mais`;
});
const fullDescription = computed(() => {
  const name = academyName.value;
  const city = academyCity.value;
  const location = city ? ` em ${city}` : "";
  return `${name}${location}. ${academyDescription.value}`;
});

useSeoMeta({
  title: () => fullTitle.value,
  description: () => fullDescription.value,
  ogLocale: "pt_BR",
  ogTitle: () => fullTitle.value,
  ogDescription: () => fullDescription.value,
  ogType: "website",
  ogUrl: () => academyWebsite.value,
  ogSiteName: () => academyName.value,
  ogImage: () => academyLogo.value ?? undefined,
  ogImageAlt: () => `Logo da ${academyName.value}`,
  twitterCard: "summary_large_image",
  twitterSite: () => config.value?.social?.instagram ?? undefined,
  twitterTitle: () => fullTitle.value,
  twitterDescription: () => fullDescription.value,
  twitterImage: () => academyLogo.value ?? undefined,
  robots: "index, follow",
  keywords: () =>
    [
      academyName.value,
      "academia",
      "musculação",
      "personal trainer",
      academyCity.value,
      academyState.value,
      "emagrecimento",
      "condicionamento físico",
      "saúde",
      "bem-estar",
      "exercícios",
      "crossfit",
    ]
      .filter(Boolean)
      .join(", "),
});

const structuredData = computed(() => {
  const sameAs: string[] = [];
  if (config.value?.social?.instagram) sameAs.push(config.value.social.instagram);
  if (config.value?.social?.facebook) sameAs.push(config.value.social.facebook);
  if (config.value?.social?.youtube) sameAs.push(config.value.social.youtube);

  const daysOfWeek: string[] = [];
  const scheduleText = config.value?.schedule?.openingHours?.toLowerCase() ?? "";
  if (scheduleText.includes("seg") || scheduleText.includes("mon")) {
    daysOfWeek.push("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
  }
  if (config.value?.schedule?.openingTime && config.value?.schedule?.closingTime && daysOfWeek.length > 0) {
    if (scheduleText.includes("sáb") || scheduleText.includes("sat")) daysOfWeek.push("Saturday");
    if (scheduleText.includes("dom") || scheduleText.includes("sun")) daysOfWeek.push("Sunday");
  }

  const obj: Record<string, unknown> = {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "@id": academyWebsite.value,
    name: academyName.value,
    description: academyDescription.value,
    url: academyWebsite.value,
    telephone: academyPhone.value,
    image: academyLogo.value,
    priceRange: "$$",
    address: academyAddress.value
      ? {
          "@type": "PostalAddress",
          streetAddress: config.value?.address?.street
            ? `${config.value.address.street}${config.value.address.number ? `, ${config.value.address.number}` : ""}`
            : undefined,
          addressLocality: academyCity.value,
          addressRegion: academyState.value,
          postalCode: config.value?.address?.zipCode ?? undefined,
          addressCountry: "BR",
        }
      : undefined,
  };

  if (academyCity.value) {
    obj.areaServed = {
      "@type": "City",
      name: academyCity.value,
    };
  }

  if (sameAs.length > 0) {
    obj.sameAs = sameAs;
  }

  if (daysOfWeek.length > 0 && config.value?.schedule?.openingTime && config.value?.schedule?.closingTime) {
    obj.openingHoursSpecification = {
      "@type": "OpeningHoursSpecification",
      dayOfWeek: daysOfWeek,
      opens: config.value.schedule.openingTime,
      closes: config.value.schedule.closingTime,
    };
  }

  return obj;
});

useHead({
  htmlAttrs: { lang: "pt-BR" },
  link: [
    {
      rel: "canonical",
      href: () => academyWebsite.value,
    },
  ],
  script: [
    {
      type: "application/ld+json",
      innerHTML: () => JSON.stringify(structuredData.value),
    },
  ],
  meta: [
    { name: "theme-color", content: "#10b981" },
    { name: "application-name", content: () => academyName.value },
  ],
});
</script>

<template>
  <div>
    <LandingNavbar />
    <LandingHero />
    <LandingModalities />
    <LandingStructure />
    <LandingPlans />
    <LandingContact />
    <LandingFooter />
  </div>
</template>

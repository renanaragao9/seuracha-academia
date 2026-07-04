interface LandingResponse {
  configuration?: {
    social?: {
      website?: string;
      instagram?: string;
    };
  };
}

export default defineEventHandler(async (event) => {
  const {
    public: { apiBase },
  } = useRuntimeConfig(event);

  let website = "https://ironfit.com.br";
  const data = await $fetch<LandingResponse>(`${apiBase}/landing`);

  if (data?.configuration) {
    const c = data.configuration;
    website = c.social?.website ?? c.social?.instagram ?? website;
  }

  const url = (path: string) => `${website.replace(/\/+$/, "")}${path}`;

  const xml = `<?xml version="1.0" encoding="UTF-8"?>
              <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
                <url>
                  <loc>${url("/")}</loc>
                  <lastmod>${new Date().toISOString().split("T")[0]}</lastmod>
                  <changefreq>weekly</changefreq>
                  <priority>1.0</priority>
                </url>
              </urlset>`;

  setHeader(event, "Content-Type", "application/xml; charset=utf-8");
  setHeader(event, "Cache-Control", "public, max-age=86400");
  return xml;
});

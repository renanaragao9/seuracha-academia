import type { TrainingSheet } from "~/interfaces/training-sheet";

export function storageUrl(
  url: string | null | undefined,
): string | null | undefined {
  if (!url) return url;
  const { public: { apiBase } } = useRuntimeConfig();
  const storageHost = (apiBase as string).replace('/api', '');
  return url.replace(/http:\/\/127\.0\.0\.1:8000/, storageHost);
}

export function rewriteSheetStorageUrls(sheet: TrainingSheet): void {
  const { public: { apiBase } } = useRuntimeConfig();
  const storageHost = (apiBase as string).replace('/api', '');

  for (const div of sheet.divisions) {
    for (const ex of div.exercises) {
      const e = ex.exercise;
      if (e.imageUrl) e.imageUrl = e.imageUrl.replace('http://127.0.0.1:8000', storageHost);
      if (e.gifUrl) e.gifUrl = e.gifUrl.replace('http://127.0.0.1:8000', storageHost);
      if (e.videoUrl) e.videoUrl = e.videoUrl.replace('http://127.0.0.1:8000', storageHost);
    }
  }
}

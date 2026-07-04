import type {
  ProfileData,
  ProfileUpdatePayload,
} from "~/interfaces/profile";
import {
  fetchProfile,
  updateProfile as updateProfileService,
  uploadProfileImage as uploadProfileImageService,
  changePassword as changePasswordService,
} from "~/services/profileService";

export const useProfileStore = defineStore("profile", () => {
  const { public: { apiBase } } = useRuntimeConfig();
  const authStore = useAuthStore();
  const toast = useToast();

  const profileData = ref<ProfileData | null>(null);
  const isLoading = ref<boolean>(true);
  const isSaving = ref<boolean>(false);
  const isChangingPassword = ref<boolean>(false);
  const isUploadingImage = ref<boolean>(false);
  const error = ref<string | null>(null);

  async function load(): Promise<void> {
    const token = authStore.token;
    if (!token) {
      navigateTo("/login");
      return;
    }

    isLoading.value = true;
    error.value = null;

    try {
      const data = await fetchProfile(apiBase, token);
      if (data) {
        if (data.student.imageUrl) {
          data.student.imageUrl = storageUrl(data.student.imageUrl) as string;
        }
        profileData.value = data;
      }
    } catch (e: unknown) {
      error.value = "Não foi possível carregar o perfil.";
      console.error(e);
    } finally {
      isLoading.value = false;
    }
  }

  async function saveProfile(payload: ProfileUpdatePayload): Promise<boolean> {
    const token = authStore.token;
    if (!token) return false;

    isSaving.value = true;

    try {
      const data = await updateProfileService(apiBase, token, payload);
      if (data) {
        if (data.student.imageUrl) {
          data.student.imageUrl = storageUrl(data.student.imageUrl) as string;
        }
        profileData.value = data;

        authStore.setAuth(
          {
            id: data.user.id,
            name: data.user.name,
            email: data.user.email,
            phone: data.user.phone,
            imageUrl: data.user.imageUrl,
          },
          token,
        );

        toast.success("Perfil atualizado", "Seus dados foram salvos com sucesso.");
        return true;
      }
      return false;
    } catch (err: unknown) {
      const apiErrors = (err as { data?: { errors?: Record<string, string[]> } })?.data?.errors;
      const message = apiErrors
        ? Object.values(apiErrors).flat().join(", ")
        : "Não foi possível salvar os dados.";
      toast.error("Erro ao salvar", message);
      return false;
    } finally {
      isSaving.value = false;
    }
  }

  async function uploadImage(file: File): Promise<boolean> {
    const token = authStore.token;
    if (!token) return false;

    isUploadingImage.value = true;

    try {
      const data = await uploadProfileImageService(apiBase, token, file);
      if (data) {
        if (data.user.imageUrl) {
          data.user.imageUrl = storageUrl(data.user.imageUrl) as string;
        }
        profileData.value = data;

        authStore.setAuth(
          {
            id: data.user.id,
            name: data.user.name,
            email: data.user.email,
            phone: data.user.phone,
            imageUrl: data.user.imageUrl,
          },
          token,
        );

        toast.success("Imagem atualizada", "Sua foto de perfil foi alterada.");
        return true;
      }
      return false;
    } catch (err: unknown) {
      const apiErrors = (err as { data?: { errors?: Record<string, string[]> } })?.data?.errors;
      const message = apiErrors
        ? Object.values(apiErrors).flat().join(", ")
        : "Não foi possível enviar a imagem.";
      toast.error("Erro ao enviar", message);
      return false;
    } finally {
      isUploadingImage.value = false;
    }
  }

  async function changePassword(
    currentPassword: string,
    newPassword: string,
  ): Promise<boolean> {
    const token = authStore.token;
    if (!token) return false;

    isChangingPassword.value = true;

    try {
      await changePasswordService(apiBase, token, {
        current_password: currentPassword,
        password: newPassword,
        password_confirmation: newPassword,
      });
      toast.success("Senha alterada", "Sua senha foi atualizada com sucesso.");
      return true;
    } catch (err: unknown) {
      const apiErrors = (err as { data?: { errors?: Record<string, string[]> } })?.data?.errors;
      const message = apiErrors
        ? Object.values(apiErrors).flat().join(", ")
        : "Não foi possível alterar a senha.";
      toast.error("Erro", message);
      return false;
    } finally {
      isChangingPassword.value = false;
    }
  }

  return {
    profileData,
    isLoading,
    isSaving,
    isChangingPassword,
    isUploadingImage,
    error,
    load,
    saveProfile,
    uploadImage,
    changePassword,
  };
});

/**
 * Composable para acessar configurações do tema de forma programática
 * Fornece acesso centralizado às cores e configurações de design
 */

export interface ThemeColors {
  // Cores principais
  primaryEmerald: string;
  primaryEmeraldDark: string;
  primaryEmeraldLight: string;

  // Cores de fundo
  bgPrimary: string;
  bgSecondary: string;
  bgTertiary: string;

  // Cores de texto
  textPrimary: string;
  textSecondary: string;
  textTertiary: string;
  textMuted: string;

  // Cores de borda
  borderPrimary: string;
  borderLight: string;

  // Cores de estado
  error: string;
  errorBg: string;
  success: string;
}

export interface ThemeConfig {
  colors: ThemeColors;
  opacity: {
    bgCard: number;
    borderSubtle: number;
    borderLight: number;
    overlay: number;
    hover: number;
  };
  radius: {
    sm: string;
    md: string;
    lg: string;
    xl: string;
  };
  spacing: {
    card: string;
    section: string;
  };
  transition: {
    fast: string;
    base: string;
    slow: string;
    ease: string;
  };
  fontWeight: {
    medium: number;
    semibold: number;
    bold: number;
    black: number;
  };
}

export const useTheme = () => {
  /**
   * Configuração completa do tema
   * Baseada nas variáveis CSS definidas em theme.css
   */
  const theme: ThemeConfig = {
    colors: {
      // Cores principais (RGB format)
      primaryEmerald: "rgb(16 185 129)", // emerald-500
      primaryEmeraldDark: "rgb(4 120 87)", // emerald-700
      primaryEmeraldLight: "rgb(52 211 153)", // emerald-400

      // Cores de fundo
      bgPrimary: "rgb(17 24 39)", // gray-900
      bgSecondary: "rgb(31 41 55)", // gray-800
      bgTertiary: "rgb(55 65 81)", // gray-700

      // Cores de texto
      textPrimary: "rgb(255 255 255)", // white
      textSecondary: "rgb(161 161 170)", // zinc-400
      textTertiary: "rgb(212 212 216)", // zinc-300
      textMuted: "rgb(82 82 91)", // zinc-600

      // Cores de borda
      borderPrimary: "rgb(63 63 70)", // zinc-700
      borderLight: "rgb(255 255 255)", // white

      // Cores de estado
      error: "rgb(239 68 68)", // red-500
      errorBg: "rgb(239 68 68)", // red-500
      success: "rgb(34 197 94)", // green-500
    },

    opacity: {
      bgCard: 0.5,
      borderSubtle: 0.1,
      borderLight: 0.05,
      overlay: 0.1,
      hover: 0.05,
    },

    radius: {
      sm: "0.5rem", // 8px
      md: "0.75rem", // 12px
      lg: "1rem", // 16px
      xl: "1.5rem", // 24px
    },

    spacing: {
      card: "2rem",
      section: "5rem",
    },

    transition: {
      fast: "150ms",
      base: "200ms",
      slow: "300ms",
      ease: "cubic-bezier(0.4, 0, 0.2, 1)",
    },

    fontWeight: {
      medium: 500,
      semibold: 600,
      bold: 700,
      black: 900,
    },
  };

  /**
   * Helpers para gerar classes CSS do Tailwind dinamicamente
   */
  const getGradientClass = (direction: "to-r" | "to-br" = "to-r") => {
    return `bg-gradient-${direction} from-emerald-500 to-emerald-700`;
  };

  const getTextGradientClass = () => {
    return "bg-gradient-to-r from-emerald-400 to-emerald-600 bg-clip-text text-transparent";
  };

  const getCardClass = () => {
    return "rounded-2xl border border-white/10 bg-zinc-800/50 backdrop-blur-sm";
  };

  const getInputClass = () => {
    return "w-full rounded-xl border border-zinc-700 bg-zinc-900 px-4 py-3 text-white placeholder-zinc-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500/50 transition-colors";
  };

  const getButtonPrimaryClass = () => {
    return "inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-emerald-700 py-3 px-4 text-sm font-semibold text-white hover:shadow-xl hover:shadow-emerald-500/30 hover:scale-[1.02] transition-all duration-300 disabled:opacity-60 disabled:scale-100 disabled:cursor-not-allowed";
  };

  const getButtonSecondaryClass = () => {
    return "inline-flex items-center justify-center gap-2 rounded-2xl border border-white/10 text-white font-semibold hover:bg-white/5 hover:border-white/20 transition-all duration-300";
  };

  const getBadgeClass = () => {
    return "inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium";
  };

  const getErrorMessageClass = () => {
    return "flex items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 p-4";
  };

  const getIconBrandClass = (size: "sm" | "md" | "lg" = "md") => {
    const sizeMap = {
      sm: "h-8 w-8",
      md: "h-16 w-16",
      lg: "h-24 w-24",
    };
    return `flex items-center justify-center rounded-2xl bg-emerald-500/15 ${sizeMap[size]}`;
  };

  /**
   * Helper para gerar estilos inline quando necessário
   */
  const getInlineStyles = () => {
    return {
      brandGradient: {
        background: `linear-gradient(to right, ${theme.colors.primaryEmerald}, ${theme.colors.primaryEmeraldDark})`,
      },
      pageBackground: {
        background: `linear-gradient(to bottom right, ${theme.colors.bgPrimary}, ${theme.colors.bgSecondary}, ${theme.colors.bgPrimary})`,
      },
      cardBackground: {
        backgroundColor: `rgba(${theme.colors.bgTertiary}, ${theme.opacity.bgCard})`,
        backdropFilter: "blur(8px)",
      },
    };
  };

  return {
    theme,
    getGradientClass,
    getTextGradientClass,
    getCardClass,
    getInputClass,
    getButtonPrimaryClass,
    getButtonSecondaryClass,
    getBadgeClass,
    getErrorMessageClass,
    getIconBrandClass,
    getInlineStyles,
  };
};

import de from './de.json';
import en from './en.json';
import it from './it.json';

const messages = { en, it, de };
type Locale = keyof typeof messages;

function resolveLocale(): Locale {
  const fromStorage = localStorage.getItem('locale');
  if (fromStorage && fromStorage in messages) {
    return fromStorage as Locale;
  }

  const fromBrowser = navigator.language.split('-')[0] as Locale;
  return fromBrowser in messages ? fromBrowser : 'en';
}

function getByPath(obj: unknown, path: string): string | undefined {
  return path.split('.').reduce<unknown>((acc, part) => {
    if (acc && typeof acc === 'object' && part in (acc as Record<string, unknown>)) {
      return (acc as Record<string, unknown>)[part];
    }

    return undefined;
  }, obj) as string | undefined;
}

const locale = resolveLocale();

export function t(key: string): string {
  return getByPath(messages[locale], key) ?? getByPath(messages.en, key) ?? key;
}

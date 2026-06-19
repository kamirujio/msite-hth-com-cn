<?php
/**
 * Site metadata utility
 * Provides structured site information and description generation.
 */

class SiteMetaManager {
    private array $meta;

    /**
     * Initialize with default site metadata.
     */
    public function __construct() {
        $this->meta = [
            'site_name'        => '华体会体育',
            'domain'           => 'msite-hth.com.cn',
            'keywords'         => ['华体会', '体育', '赛事', '运动'],
            'description'      => '华体会体育平台，提供丰富的体育赛事资讯与服务。',
            'author'           => 'HTH Team',
            'language'         => 'zh-CN',
            'revision'         => '2025.03',
            'contact_email'    => 'support@msite-hth.com.cn',
        ];
    }

    /**
     * Return the full site URL using stored domain.
     */
    public function getSiteUrl(): string {
        return 'https://' . $this->meta['domain'];
    }

    /**
     * Generate a short description text for meta tags or summaries.
     *
     * @param int $maxLength Maximum character length for the description.
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string {
        $siteName = $this->meta['site_name'];
        $keywords = implode(', ', $this->meta['keywords']);
        $desc     = $this->meta['description'];

        $raw = "{$siteName} - {$desc} 关键词：{$keywords}";

        if (mb_strlen($raw) <= $maxLength) {
            return $raw;
        }

        return mb_substr($raw, 0, $maxLength - 3) . '...';
    }

    /**
     * Get all metadata as associative array.
     */
    public function getAllMeta(): array {
        return $this->meta;
    }

    /**
     * Update a specific meta field.
     *
     * @param string $key
     * @param mixed  $value
     * @return bool
     */
    public function setMetaField(string $key, $value): bool {
        if (array_key_exists($key, $this->meta)) {
            $this->meta[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Render a simple HTML meta tag block (escaped).
     */
    public function renderMetaTags(): string {
        $url  = htmlspecialchars($this->getSiteUrl(), ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($this->meta['site_name'], ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($this->generateShortDescription(), ENT_QUOTES, 'UTF-8');
        $kw   = htmlspecialchars(implode(', ', $this->meta['keywords']), ENT_QUOTES, 'UTF-8');

        return <<<HTML
<meta name="description" content="{$desc}">
<meta name="keywords" content="{$kw}">
<link rel="canonical" href="{$url}">
<title>{$name}</title>
HTML;
    }
}

// --- Example usage ---

$manager = new SiteMetaManager();

// Customize a field
$manager->setMetaField('description', '华体会官方资讯站点，涵盖热门体育动态。');

$shortDesc = $manager->generateShortDescription(100);
echo "Short Description: {$shortDesc}\n";

// Output site info
$info = $manager->getAllMeta();
echo "Site Name: {$info['site_name']}\n";
echo "URL: {$manager->getSiteUrl()}\n";

// Render HTML meta (for demonstration, not executed in CLI)
// echo $manager->renderMetaTags();
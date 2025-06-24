import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const {
		imageUrl,
		title,
		subtitle,
		description,
		linkUrl,
		linkText
	} = attributes;

	return (
		<div { ...useBlockProps.save() } className="project-card">
			{ imageUrl && (
				<div className="project-card__image">
					<img src={imageUrl} alt="" />
				</div>
			) }

			<div className="project-card__content">
				{ title && (
					<RichText.Content
						tagName="h3"
						className="project-card__title"
						value={title}
					/>
				)}

				{ subtitle && (
					<RichText.Content
						tagName="p"
						className="project-card__subtitle"
						value={subtitle}
					/>
				)}

				{ description && (
					<RichText.Content
						tagName="p"
						className="project-card__description"
						value={description}
					/>
				)}

				{ linkUrl && (
					<a
						className="project-card__link"
						href={linkUrl}
					>
						{ linkText || 'Learn More' }
					</a>
				)}
			</div>
		</div>
	);
}

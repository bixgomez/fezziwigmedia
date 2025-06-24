import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, URLInputButton } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const {
		title,
		subtitle,
		description,
		imageUrl,
		linkUrl,
		linkText
	} = attributes;

	const onSelectImage = (media) => {
		setAttributes({ imageUrl: media.url });
	};

	return (
		<div { ...useBlockProps() } className="project-card-block">
			<MediaUploadCheck>
				<MediaUpload
					onSelect={onSelectImage}
					allowedTypes={['image']}
					render={({ open }) => (
						<Button onClick={open} className="project-card-block__image-button">
							{ imageUrl ? (
								<img src={imageUrl} alt="Project thumbnail" />
							) : (
								__('Upload Image', 'project-card')
							)}
						</Button>
					)}
				/>
			</MediaUploadCheck>

			<RichText
				tagName="h3"
				value={title}
				placeholder={__('Project Title', 'project-card')}
				onChange={(value) => setAttributes({ title: value })}
			/>

			<RichText
				tagName="p"
				className="project-card-block__subtitle"
				value={subtitle}
				placeholder={__('Subtitle or Tags', 'project-card')}
				onChange={(value) => setAttributes({ subtitle: value })}
			/>

			<RichText
				tagName="p"
				className="project-card-block__description"
				value={description}
				multiline="p"
				placeholder={__('Project description...', 'project-card')}
				onChange={(value) => setAttributes({ description: value })}
			/>

			<div className="project-card-block__link">
				<URLInputButton
					url={linkUrl}
					onChange={(url) => setAttributes({ linkUrl: url })}
				/>
				<RichText
					tagName="span"
					value={linkText}
					placeholder={__('Link text', 'project-card')}
					onChange={(value) => setAttributes({ linkText: value })}
				/>
			</div>
		</div>
	);
}
